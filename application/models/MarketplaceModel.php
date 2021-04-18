<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MarketplaceModel extends CI_Model
{

    public function GetProducts()
    {

        /**
         * 
            select view_products.*, 
                marketplace_user_ratings.id, 
                marketplace_user_ratings.user_id, 
                marketplace_user_ratings.rated_user_id, 
                marketplace_user_ratings.rating, 
                view_seller_ratings.rating_ave 
            from view_products 
            left join view_seller_ratings  on seller_id  = rated_id
            left join marketplace_user_ratings 
                on view_seller_ratings.user_id = marketplace_user_ratings.user_id 
                    AND view_seller_ratings.rated_id = marketplace_user_ratings.rated_user_id
         */
        $q = $this->db->select("view_products.*")
            ->select("marketplace_user_ratings.id")
            ->select("marketplace_user_ratings.user_id")
            ->select("marketplace_user_ratings.rated_user_id")
            ->select("marketplace_user_ratings.rating")
            ->select("view_seller_ratings.rating_ave")
            ->from("view_products")
            ->join("view_seller_ratings", "seller_id  = rated_id", "left")
            ->join("marketplace_user_ratings", 
                "view_seller_ratings.user_id = marketplace_user_ratings.user_id 
                AND view_seller_ratings.rated_id = marketplace_user_ratings.rated_user_id", "left")
            ->order_by('product_id', 'DESC')
            ->get();
        // $this->db->join('view_seller_ratings', 'seller_id = rated_id', 'left');
        // $this->db->order_by('product_id', 'DESC');
        // $q = $this->db->get('view_products');

        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public function GetActiveProduct($id)
    {
        $q = $this->db->get_where('view_products', array(
            'product_status' => 1,
            'product_id' => $id
        ));

        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function GetActiveProducts()
    {
        $this->db->order_by('product_id', 'DESC');
        $q = $this->db->get_where('view_products', array('product_status' => 1));

        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public function GetProduct($id)
    {
        $q = $this->db->get_where('view_products', array('product_id' => $id));
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }


    public function UpdateProduct($id, $data)
    {
        $this->db->set($data);
        $this->db->where(array('id' => $id));
        $this->db->update('marketplace');
    }

    public function DeleteProduct($id)
    {
        //set is_delete = 1
        $this->db->set("is_deleted", 1);
        $this->db->where(array('id' => $id));
        $this->db->update('marketplace');
    }

    public function CreateProduct($data)
    {
        $this->db->insert('marketplace', $data);
        return $this->db->insert_id();
    }

    public function CreateOrder($data)
    {
        $this->db->insert('marketplace_transactions', $data);
        return $this->db->insert_id();
    }

    public function InsertGalleryImage($data)
    {
        $this->db->insert('marketplace_images', $data);
    }

    public function GetGalleryImage($product_id){
        return $this->db->get_where('marketplace_images',
            array("marketplace_id" => $product_id));
    }

    public function DeleteGalleryImage($product_id){
        return $this->db->delete('marketplace_images',
            array("marketplace_id" => $product_id));
    }

    public function SearchProduct($term)
    {
        $this->db->like(array('item_name' => $term));
        $q = $this->db->get('view_products');
        
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public function RateSeller($data)
    {
        $this->db->insert('marketplace_user_ratings', $data);
    }

    public function CheckIfRated($id, $rated_user_id)
    {
        $q = $this->db->get_where('marketplace_user_ratings', array(
            'user_id' => $id,
            'rated_user_id' => $rated_user_id,
        ));

        if ($q->num_rows() > 0) {
            return true;
        }
        return false;
    }

    public function GetProductRatings()
    {
        $q = $this->db->get('view_seller_ratings');

        if ($q->num_rows() > 0) {
            return $q->result();
        }

        return array();
    }

    
}
