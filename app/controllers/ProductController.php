<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ProductController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->call->model('Product');
    }

    // READ - Display all products
    public function index()
    {
        $data['products'] = $this->Product->all();

        $this->call->view('products/index', $data);
    }

    // CREATE - Show form and save product
    public function create()
    {
        if ($this->io->method() == 'post') {

            $data = [
                'product_name' => $this->io->post('product_name'),
                'description'  => $this->io->post('description'),
                'price'        => $this->io->post('price'),
                'quantity'     => $this->io->post('quantity')
            ];

            $this->Product->insert($data);

            redirect('products');
        }

        $this->call->view('products/create');
    }

    // UPDATE - Show form and update product
    public function edit($id)
    {
        $product = $this->Product->find($id);

        if (!$product) {
            echo "Product not found.";
            return;
        }

        if ($this->io->method() == 'post') {

            $data = [
                'product_name' => $this->io->post('product_name'),
                'description'  => $this->io->post('description'),
                'price'        => $this->io->post('price'),
                'quantity'     => $this->io->post('quantity')
            ];

            $this->Product->update($id, $data);

            redirect('products');
        }

        $this->call->view('products/edit', [
            'product' => $product
        ]);
    }

    // DELETE - Delete product
    public function delete($id)
    {
        $this->Product->delete($id);

        redirect('products');
    }
}