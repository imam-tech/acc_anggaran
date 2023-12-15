<?php

namespace App\Repositories;

use App\Models\ManufactureProduct;
use App\Models\ManufactureProductDetail;
use App\Models\ManufactureProductDetailItem;
use App\Models\Material;
use App\Models\MaterialHistory;
use App\Models\SemiFinishedMaterial;
use App\Models\SemiFinishedMaterialItem;
use App\Services\DigitalOceanService;
use Illuminate\Support\Facades\DB;

class ManufactureRepository {
    public function storeMaterial($request, $companyId) {
        try {
            $validator = \Validator::make($request->all(), [
                "name" => 'required',
                "unit" => 'required'
            ]);

            if ($validator->fails()) return resultFunction("Err code MR-SM: " . collect($validator->errors()->all())->implode(" , "));

            $data = $request->all();

            $isNewImage = "";
            if ($data['image']) {
                $resultImage = (new DigitalOceanService())->uploadImageToDO($data['image'], 'material');
                if (!$resultImage['status']) return $resultImage;

                $isNewImage = $resultImage['data'];
            }

            if ($data['id']) {
                $material = Material::find($data['id']);
                if (!$material) return resultFunction("Err code MR-SM: material not found");
            } else {
                $material = new Material();
                $material->company_id = $companyId;
                $material->stock = 0;
                $material->last_price_per_unit = 0;
            }

            $material->name = $data['name'];
            $material->unit = $data['unit'];
            if ($isNewImage) {
                $material->image = $isNewImage;
            }
            $material->save();

            return resultFunction("Processing data is successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code MR-SM: catch " . $e->getMessage());
        }
    }

    public function storeSemiFinishedMaterial($data, $companyId) {
        try {
            $validator = \Validator::make($data, [
                "name" => 'required',
                "items" => 'required'
            ]);

            if ($validator->fails()) return resultFunction("Err code MR-SMM: " . collect($validator->errors()->all())->implode(" , "));

            if ($data['id']) {
                $semiFinishedMaterial = SemiFinishedMaterial::find($data['id']);
                if (!$semiFinishedMaterial) return resultFunction("Err code MR-SMM: semi finished material not found");
            } else {
                $semiFinishedMaterial = new SemiFinishedMaterial();
            }
            $semiFinishedMaterial->name = $data['name'];
            $semiFinishedMaterial->save();

            foreach ($data['items'] as $item) {
                $semiFinishedMaterialItem = new SemiFinishedMaterialItem();
                $semiFinishedMaterialItem->semi_finished_material_id = $semiFinishedMaterial->id;
                $semiFinishedMaterialItem->material_id = $item['id'];
                $semiFinishedMaterialItem->dose = $item['dose'];
                $semiFinishedMaterialItem->save();
            }

            return resultFunction("Processing data is successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code MR-SMM: catch " . $e->getMessage());
        }
    }

    public function storeProduct($data, $companyId) {
        try {
            DB::beginTransaction();

            $validator = \Validator::make($data, [
                "name" => 'required',
                "products" => 'required'
            ]);

            if ($validator->fails()) return resultFunction("Err code MR-SP: " . collect($validator->errors()->all())->implode(" , "));

            if ($data['id']) {
                $manufactureProduct = ManufactureProduct::find($data['id']);
                if (!$manufactureProduct) return resultFunction("Err code MR-SP: manufacture product not found");

                if ($manufactureProduct->status !== null) return resultFunction("Err code MR-SP: manufacture is not available to edit");

                ManufactureProductDetail::where('manufacture_product_id', $manufactureProduct->id)->delete();
                ManufactureProductDetailItem::where('manufacture_product_id', $manufactureProduct->id)->delete();
            } else {
                $manufactureProduct = new ManufactureProduct();
                $manufactureProduct->company_id = $companyId;
                $manufactureProduct->status = 'DRAFT';
            }
            $manufactureProduct->name = $data['name'];
            $manufactureProduct->description = $data['description'];
            $manufactureProduct->amount_total = 0;
            $manufactureProduct->save();

            $amountFinal = 0;
            foreach ($data['products'] as $product) {
                $manufactureProductDetail = new ManufactureProductDetail();
                $manufactureProductDetail->manufacture_product_id = $manufactureProduct->id;
                $manufactureProductDetail->semi_finished_material_id = $product['id'];
                $manufactureProductDetail->semi_finished_material_name = $product['name'];
                $manufactureProductDetail->amount_total = 0;
                $manufactureProductDetail->save();

                $amounTotal = 0;
                foreach ($product['items'] as $item) {
                    $manufactureProductDetailItem = new ManufactureProductDetailItem();
                    $manufactureProductDetailItem->manufacture_product_id = $manufactureProduct->id;
                    $manufactureProductDetailItem->manufacture_product_detail_id = $manufactureProductDetail->id;
                    $manufactureProductDetailItem->name = $item['material']['name'];
                    $manufactureProductDetailItem->image = $item['material']['image'];
                    $manufactureProductDetailItem->unit = $item['material']['unit'];
                    $manufactureProductDetailItem->dose = $item['dose'];
                    $manufactureProductDetailItem->amount_total = $item['dose'] * $item['material']['last_price_per_unit'];
                    $manufactureProductDetailItem->save();
                    $amounTotal = $amounTotal + ($item['dose'] * $item['material']['last_price_per_unit']);
                }
                $manufactureProductDetail->amount_total = $amounTotal;
                $manufactureProductDetail->save();
                $amountFinal = $amountFinal + $manufactureProductDetail->amount_total;
            }
            $manufactureProduct->amount_total = $amountFinal;
            $manufactureProduct->save();

            DB::commit();
            return resultFunction("Processing data is successfully", true, $manufactureProduct);
        } catch (\Exception $e) {
            return resultFunction("Err code MR-SP: catch " . $e->getMessage());
        }
    }

    public function detailProduct($id) {
        try {
            $manufactureProduct = ManufactureProduct::with(['manufacture_product_details.manufacture_product_detail_items',
                'manufacture_product_details.semi_finished_material.semi_finished_material_items.material'])->find($id);
            if (!$manufactureProduct) return resultFunction("Err code SR-D: purchase not found");

            return resultFunction("", true, $manufactureProduct);
        } catch (\Exception $e) {
            return resultFunction("Err code SR-D: catch " . $e->getMessage());
        }
    }

    public function approveProduct($id) {
        try {
            DB::beginTransaction();

            $manufactureProduct = ManufactureProduct::with(['manufacture_product_details.manufacture_product_detail_items',
                'manufacture_product_details.semi_finished_material.semi_finished_material_items.material'])->find($id);
            if (!$manufactureProduct) return resultFunction("Err code SR-D: purchase not found");

            if ($manufactureProduct->status !== 'DRAFT') return resultFunction("Err code MR-AP: status is not draft");

            $materialIds = [];
            $doses = [];
            // Check existing stock
            foreach ($manufactureProduct->manufacture_product_details as $manufacture_product_detail) {
                foreach ($manufacture_product_detail->semi_finished_material->semi_finished_material_items as $item) {
                    if (!in_array($item->material_id, $materialIds)) {
                        $materialIds[] = $item->material_id;
                    }
                    if (isset($doses[$item->material_id])) {
                        $doses[$item->material_id] = $doses[$item->material_id] + $item['dose'];
                    } else {
                        $doses[$item->material_id] = $item['dose'];
                    }
                }
            }

            $materials = Material::whereIn('id', $materialIds)->get();
            foreach ($materials as $key => $material) {
                if ($doses[$material->id] > $material->stock) {
                    return resultFunction("Err code MR-AP: stock is not enough");
                }
            }

            $manufactureProduct->status = "approve";
            $manufactureProduct->save();

            foreach ($materials as $key => $material) {
                $materialHistory = new MaterialHistory();
                $materialHistory->material_id = $material->id;
                $materialHistory->type_history = 'manufacture product';
                $materialHistory->stock = -1 * $doses[$material->id];
                $materialHistory->note = "Manufacture product #" . $manufactureProduct->id;
                $materialHistory->price_per_unit = 0;
                $materialHistory->save();

                $material->stock = $material->stock -  $doses[$material->id];
                $material->save();
            }

            DB::commit();
            return resultFunction("Updating manufacture product is successfully", true, $manufactureProduct);
        } catch (\Exception $e) {
            return resultFunction("Err code MR-AP: catch " . $e->getMessage());
        }
    }
}