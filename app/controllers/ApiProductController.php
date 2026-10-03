<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * ProductController
 * CRUD ng products. Lahat ng method ay protected ng JWT (require_jwt),
 * kaya authenticated users lang ang makakagamit.
 */
class ApiProductController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->library('api');
    }

    // Kunin at i-validate ang product data galing sa request body
    private function validated_input(array $input, array $existing = [])
    {
        $name  = array_key_exists('product_name', $input) ? trim((string)$input['product_name']) : ($existing['product_name'] ?? '');
        $desc  = array_key_exists('description', $input)  ? trim((string)$input['description'])  : ($existing['description'] ?? '');
        $price = array_key_exists('price', $input)        ? $input['price']                       : ($existing['price'] ?? null);
        $qty   = array_key_exists('quantity', $input)     ? $input['quantity']                    : ($existing['quantity'] ?? null);

        if ($name === '' || strlen($name) > 100) {
            $this->api->respond_error('product_name ay required at hanggang 100 characters lang.', 422);
        }
        if (!is_numeric($price) || $price < 0) {
            $this->api->respond_error('price ay dapat number na hindi negative.', 422);
        }
        if (!is_numeric($qty) || (int)$qty != $qty || $qty < 0) {
            $this->api->respond_error('quantity ay dapat buong number na hindi negative.', 422);
        }

        return [
            'product_name' => $name,
            'description'  => $desc,
            'price'        => round((float)$price, 2),
            'quantity'     => (int)$qty,
        ];
    }

    private function find_or_404($id)
    {
        $product = $this->db->table('products')->where('id', (int)$id)->row_array();
        if (!$product) {
            $this->api->respond_error('Product not found', 404);
        }
        return $product;
    }

    // GET /api/products
    public function index()
    {
        $this->api->require_method('GET');
        $this->api->require_jwt();

        $products = $this->db->table('products')
                             ->order_by('id', 'DESC')
                             ->result_array();

        $this->api->respond($products);
    }

    // GET /api/products/{id}
    public function show($id)
    {
        $this->api->require_method('GET');
        $this->api->require_jwt();

        $this->api->respond($this->find_or_404($id));
    }

    // POST /api/products
    public function store()
    {
        $this->api->require_method('POST');
        $this->api->require_jwt();

        $data = $this->validated_input($this->api->body());

        $this->db->table('products')->insert($data);
        $id = $this->db->last_id();

        $this->api->respond([
            'message' => 'Product created',
            'product' => $this->find_or_404($id),
        ], 201);
    }

    // PUT /api/products/{id}
    public function update($id)
    {
        $this->api->require_method('PUT');
        $this->api->require_jwt();

        $existing = $this->find_or_404($id);
        $data     = $this->validated_input($this->api->body(), $existing);

        $this->db->table('products')->where('id', (int)$id)->update($data);

        $this->api->respond([
            'message' => 'Product updated',
            'product' => $this->find_or_404($id),
        ]);
    }

    // DELETE /api/products/{id}
    public function destroy($id)
    {
        $this->api->require_method('DELETE');
        $this->api->require_jwt();

        $this->find_or_404($id);
        $this->db->table('products')->where('id', (int)$id)->delete();

        $this->api->respond(['message' => 'Product deleted']);
    }
}