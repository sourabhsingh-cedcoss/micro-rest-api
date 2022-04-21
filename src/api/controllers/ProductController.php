<?php

use Phalcon\Mvc\Controller;
use Firebase\JWT\JWT;

class ProductController extends Controller
{


    /**
     * search($keyword)
     *
     * controller function to send search response
     * 
     * @param [type] $keyword
     * @return response
     */
    public function search($keyword)
    {

        $keyword = explode(" ", urldecode(
            $this->escaper->sanitize($keyword)
        ));
        $products = $this->product->search($keyword);
        $this->response->setStatusCode(200);
        $response = $this->response->setJsonContent($products);
        return $response;
    }

    /**
     * getAll()
     * 
     * controller function to return all products
     *
     * @return response
     */
    public function getAll()
    {

        $products = $this->product->getAll();
        $this->response->setStatusCode(200);
        $response = $this->response->setJsonContent($products);
        return $response;
    }


    /**
     * getSingle($id)
     * 
     * controller function to return all products
     *
     * @return response
     */
    public function getSingle($id)
    {

        $products = $this->product->getSingle(
            $this->escaper->sanitize($id)
        );
        $this->response->setStatusCode(200);
        $response = $this->response->setJsonContent($products);
        return $response;
    }
    /**
     * get($key, $per_page, $page, $select, $filter)
     * 
     * controller to send products
     *
     * @param integer $per_page
     * @param integer $page
     * @param string $select
     * @param string $filter
     * @return response
     */
    public function get($per_page = 10, $page = 1, $select = "", $filter = "")
    {

        $products = $this->product->get(
            $this->escaper->sanitize(
                $per_page
            ),
            $this->escaper->sanitize(
                $page
            ),
            $this->escaper->sanitize(
                $select
            ),
            $this->escaper->sanitize(
                $filter
            )
        );
        $this->response->setStatusCode(200);
        $response = $this->response->setJsonContent($products);
        return $response;
    }

    public function addProduct()
    {
        if ($this->request->getPost()) {
            $data = $this->request->getPost();
            foreach ($data as $key => $value) {
                $data['key'] = $this->escaper->sanitize($value);
            }
            $status = $this->product->postProduct($data);
            if ($status) {
                $this->response->setStatusCode(201);
                return $this->response->setJsonContent(['message' => 'created']);
            }
        }
    }

    public function updateProduct()
    {

        if ($this->request->getPut()) {
            $data = $this->request->getPut();
            foreach ($data as $key => $value) {
                $data['key'] = $this->escaper->sanitize($value);
            }
            $status = $this->product->putProduct($data);
            if ($status) {
                $this->response->setStatusCode(201);
                return $this->response->setJsonContent(['message' => 'updated']);
            }
        }
    }

    public function deleteProduct($id)
    {
        if ($id) {
            $status = $this->product->deleteProduct($this->escaper->sanitize($id));
            if ($status) {
                $this->response->setStatusCode(201);
                return $this->response->setJsonContent(['message' => 'deleted']);
            }
        }
    }
}