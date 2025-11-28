<?php

class Controller
{
    private $file;

    public function __construct()
    {
        $this->file = __DIR__ . '/products.json';
    }

    private function loadArq()
    {
        if (!file_exists($this->file)) {
            file_put_contents($this->file, "[]");
        }

        return json_decode(file_get_contents($this->file), true);
    }

    private function saveProduct($data)
    {
        file_put_contents($this->file, json_encode($data));
    }

    public function getAll()
    {
        echo json_encode($this->loadArq());
    }

    public function create($data)
    {
        $products = $this->loadArq();

        if (empty($data['name']) || empty($data['code']) || empty($data['price']) || empty($data['quantity'])) {
            http_response_code(400);
            echo "error";
            return;
        }

        $products[] = [
            "id" => uniqid(),
            "name" => $data["name"],
            "code" => $data["code"],
            "price" => floatval($data["price"]),
            "quantity" => intval($data["quantity"])
        ];

        $this->saveProduct($products);

        http_response_code(201);
        echo json_encode(["success" => true]);
    }
    
    public function delete($id)
    {
        $products = $this->loadArq();

        $filtered = array_filter($products, fn($p) => $p["id"] !== $id);

        $this->saveProduct(array_values($filtered));

        echo json_encode(["success" => true]);
    }
}
