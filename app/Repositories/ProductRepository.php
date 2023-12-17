<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\ProductHistory;
use App\Models\ProductUnit;
use App\Services\DigitalOceanService;

class ProductRepository {
    public function storeUnit($data, $companyId) {
        try {
            $validator = \Validator::make($data, [
                "name" => "required",
            ]);

            if ($validator->fails()) return resultFunction("Err code PR-SU: " . collect($validator->errors()->all())->implode(" , "));


            $message = "Creating";
            if ($data['id']) {
                $productUnit = ProductUnit::find($data['id']);
                if (!$productUnit) return resultFunction("Err code PR-SU: unit not found for ID " . $data['id']);
                $message = 'Updating';
            } else {
                $productUnit = new ProductUnit();
                $productUnit->company_id = $companyId;
            }
            $productUnit->name = $data['name'];
            $productUnit->save();

            return resultFunction($message . " unit is successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-SU: catch " . $e->getMessage());
        }
    }

    public function deleteUnit($id) {
        try {
            $productUnit = ProductUnit::find($id);
            if (!$productUnit) return resultFunction("Err code PR-DU: unit not found");

            $productUnit->delete();

            return resultFunction("Deleting unit successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-DU: catch " . $e->getMessage());
        }
    }

    public function storeCategory($request, $companyId) {
        try {
            $validator = \Validator::make($request->all(), [
                "name" => "required",
            ]);

            if ($validator->fails()) return resultFunction("Err code PR-SC: " . collect($validator->errors()->all())->implode(" , "));

            $data = $request->all();

            $isNewImage = "";
            if ($data['image']) {
                $resultImage = (new DigitalOceanService())->uploadImageToDO($data['image'], 'product-category');
                if (!$resultImage['status']) return $resultImage;

                $isNewImage = $resultImage['data'];
            }

            $message = "Creating";
            if ($data['id']) {
                $productCategory = ProductCategory::find($data['id']);
                if (!$productCategory) return resultFunction("Err code PR-SC: category not found for ID " . $data['id']);
                $message = 'Updating';
            } else {
                $productCategory = new ProductCategory();
                $productCategory->company_id = $companyId;
            }
            if ($isNewImage) {
                $productCategory->image = $isNewImage;
            }
            $productCategory->name = $data['name'];
            $productCategory->save();

            return resultFunction($message . " category is successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-SC: catch " . $e->getMessage());
        }
    }

    public function deleteCategory($id) {
        try {
            $productCategory = ProductCategory::find($id);
            if (!$productCategory) return resultFunction("Err code PR-DU: product category not found");

            $productCategory->delete();

            return resultFunction("Deleting product category successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-DU: catch " . $e->getMessage());
        }
    }

    public function store($request, $companyId) {
        try {
            $validator = \Validator::make($request->all(), [
                "name" => 'required',
            ]);

            if ($validator->fails()) return resultFunction("Err code PR-S: " . collect($validator->errors()->all())->implode(" , "));

            $data = $request->all();

            $isNewImage = "";
            if ($data['image']) {
                $resultImage = (new DigitalOceanService())->uploadImageToDO($data['image'], 'material');
                if (!$resultImage['status']) return $resultImage;

                $isNewImage = $resultImage['data'];
            }

            $category = null;
            if ($data['product_category_id']) {
                $category = ProductCategory::find($data['product_category_id']);
                if (!$category) return resultFunction("Err code PR-S: category not found");
            }

            $unit = null;
            if ($data['product_unit_id']) {
                $unit = ProductUnit::find($data['product_unit_id']);
                if (!$unit) return resultFunction("Err code PR-S: unit not found");
            }

            $message = "Creating";
            if ($data['id']) {
                $product = Product::find($data['id']);
                if (!$product) return resultFunction("Err code PR-S: product not found for ID " . $data['id']);
                $message = 'Updating';
            } else {
                $product = new Product();
                $product->company_id = $companyId;
            }


            if ($isNewImage) {
                $product->image = $isNewImage;
            }

            if ($data['product_category_id']) $product->product_category_id = $category->id;
            if ($data['product_unit_id']) $product->product_unit_id = $unit->id;
            $product->name = $data['name'];
            $product->sku_code = $data['sku_code'];
            $product->description = $data['description'];
            $product->is_sale = $data['is_sale'];
            $product->unit_sale_price = $data['unit_sale_price'];
            $product->sale_account_id = $data['sale_account_id'];
            $product->sale_tax_id = $data['sale_tax_id'];
            $product->is_purchase = $data['is_purchase'];
            $product->unit_purchase_price = $data['unit_purchase_price'];
            $product->purchase_account_id = $data['purchase_account_id'];
            $product->purchase_tax_id = $data['purchase_tax_id'];
            $product->save();

            return resultFunction($message . " product is successfully", true, $product);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-S: catch " . $e->getMessage());
        }
    }

    public function detail($id, $companyId) {
        try {
            $product = Product::with(['category', 'unit'])->find($id);
            if (!$product) return resultFunction("Err code PR-DU: product not found");

            if ($product->company_id != $companyId) return resultFunction("Err code PR-DU: product not found");

            return resultFunction("", true, $product);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-DU: catch " . $e->getMessage());
        }
    }
}