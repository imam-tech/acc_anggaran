<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\ProductHistory;
use App\Models\ProductUnit;

class ProductRepository {
    public function storeUnit($data, $companyId) {
        try {
            $validator = \Validator::make($data, [
                "title" => "required",
            ]);

            if ($validator->fails()) return resultFunction("Err code PR-SU: " . collect($validator->errors()->all())->implode(" , "));


            $message = "Creating";
            if ($data['id']) {
                $productUnit = ProductUnit::find($data['id']);
                if (!$productUnit) return resultFunction("Err code PR-SU: product unit not found for ID " . $data['id']);
                $message = 'Updating';
            } else {
                $productUnit = new ProductUnit();
                $productUnit->company_id = $companyId;
            }
            $productUnit->title = $data['title'];
            $productUnit->save();

            return resultFunction($message . " product unit is successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-SU: catch " . $e->getMessage());
        }
    }

    public function deleteUnit($id) {
        try {
            $productUnit = ProductUnit::find($id);
            if (!$productUnit) return resultFunction("Err code PR-DU: product unit not found");

            $productUnit->delete();

            return resultFunction("Deleting product unit successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-DU: catch " . $e->getMessage());
        }
    }

    public function storeBrand($data, $companyId) {
        try {
            $validator = \Validator::make($data, [
                "title" => "required",
                "image" => "required",
            ]);

            if ($validator->fails()) return resultFunction("Err code PR-SU: " . collect($validator->errors()->all())->implode(" , "));


            $message = "Creating";
            if ($data['id']) {
                $productBrand = ProductBrand::find($data['id']);
                if (!$productBrand) return resultFunction("Err code PR-SU: product unit not found for ID " . $data['id']);
                $message = 'Updating';
            } else {
                $productBrand = new ProductBrand();
                $productBrand->company_id = $companyId;
            }
            $productBrand->image = $data['image'];
            $productBrand->title = $data['title'];
            $productBrand->save();

            return resultFunction($message . " product brand is successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-SU: catch " . $e->getMessage());
        }
    }

    public function deleteBrand($id) {
        try {
            $productBrand = ProductBrand::find($id);
            if (!$productBrand) return resultFunction("Err code PR-DU: product brand not found");

            $productBrand->delete();

            return resultFunction("Deleting product brand successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-DU: catch " . $e->getMessage());
        }
    }

    public function storeCategory($data, $companyId) {
        try {
            $validator = \Validator::make($data, [
                "title" => "required",
                "image" => "required",
            ]);

            if ($validator->fails()) return resultFunction("Err code PR-SU: " . collect($validator->errors()->all())->implode(" , "));


            $message = "Creating";
            if ($data['id']) {
                $productCategory = ProductCategory::find($data['id']);
                if (!$productCategory) return resultFunction("Err code PR-SU: product unit not found for ID " . $data['id']);
                $message = 'Updating';
            } else {
                $productCategory = new ProductCategory();
                $productCategory->company_id = $companyId;
            }
            $productCategory->image = $data['image'];
            $productCategory->title = $data['title'];
            $productCategory->save();

            return resultFunction($message . " product category is successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-SU: catch " . $e->getMessage());
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

    public function store($data, $companyId) {
        try {
            $validator = \Validator::make($data, [
                "product_name" => 'required',
                "product_image" => 'required',
                "category" => 'required',
                "brand" => 'required',
                "unit" => 'required',
                "quantity_alert" => 'required',
                "selling_price" => 'required',
                "purchase_price" => 'required',
            ]);

            if ($validator->fails()) return resultFunction("Err code PR-S: " . collect($validator->errors()->all())->implode(" , "));

            $category = ProductCategory::find($data['category']);
            if (!$category) return resultFunction("Err code PR-S: product category not found");

            $brand = ProductBrand::find($data['brand']);
            if (!$brand) return resultFunction("Err code PR-S: product brand not found");

            $unit = ProductUnit::find($data['unit']);
            if (!$unit) return resultFunction("Err code PR-S: product unit not found");

            $message = "Creating";
            if ($data['id']) {
                $product = Product::find($data['id']);
                if (!$product) return resultFunction("Err code PR-S: product not found for ID " . $data['id']);
                $message = 'Updating';
            } else {
                $product = new Product();
                $product->company_id = $companyId;
                $product->stock = $data['opening_stock'];
            }
            $product->category = $category->title;
            $product->brand = $brand->title;
            $product->unit = $unit->title;
            $product->product_name = $data['product_name'];
            $product->product_image = $data['product_image'];
            $product->selling_price = $data['selling_price'];
            $product->purchase_price = $data['purchase_price'];
            $product->quantity_alert = $data['quantity_alert'];
            $product->description = $data['description'] ?? '';
            $product->save();

            if (!$data['id']) {
                $productHistory = new ProductHistory();
                $productHistory->product_id = $product->id;
                $productHistory->type = 'add';
                $productHistory->stock = $data['opening_stock'];
                $productHistory->note = 'Auto create';
                $productHistory->save();
            }

            return resultFunction($message . " product is successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-S: catch " . $e->getMessage());
        }
    }

    public function detail($id) {
        try {
            $product = Product::find($id);
            if (!$product) return resultFunction("Err code PR-DU: product not found");

            return resultFunction("", true, $product);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-DU: catch " . $e->getMessage());
        }
    }
}