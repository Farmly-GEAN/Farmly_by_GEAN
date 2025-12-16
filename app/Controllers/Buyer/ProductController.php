<?php
namespace App\Controllers\Buyer;

use App\Models\Product;

class ProductController {
    public function index(): void {
        $products = Product::all();
        $this->render('buyer/product_list', ['products' => $products]);
    }

    public function show(string $id): void {
        $product = Product::find((int)$id);
        if (!$product) { http_response_code(404); echo 'Product not found'; return; }
        $this->render('buyer/product_detail', ['product' => $product]);
    }

    private function render(string $view, array $data = []): void {
        extract($data);
        $viewFile = __DIR__ . '/../../Views/' . $view . '.php';
        $layout = __DIR__ . '/../../Views/layouts/main.php';
        ob_start();
        require $viewFile;
        $content = ob_get_clean();
        require $layout;
    }
}
