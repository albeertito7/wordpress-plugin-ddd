<?php

/**
 * Class PackageRepository
 */
class PackageRepository extends MasterRepository {

    private $table_name;

    public function __construct()
    {
        parent::__construct();

        $this->table_name= $this->db->prefix . 'entities_packages';
    }

    /**
     * @param $data
     * @return bool|false|string
     */
    public function createPackage($data) {

        /**
         * receive the data? or receive an object (Package)?
         */

        // data: status, name, short_description, description, featured_image, observations, custom_order, price
        $result = array('success' => false );

        $result_db = false;

        try {

            $result_db = $this->db->insert($this->table_name, array(
                'blog_id' => $this->current_blog_id,
                'status' => $_POST['status'],
                'name' => $_POST['name'],
                'short_description' => $_POST['short_description'],
                'description' => $_POST['description'],
                'featured_image' => $_POST['featured_image'],
                'observations' => $_POST['observations'],
                'custom_order' => $_POST['custom_order'],
                'price' => $_POST['price']
            ));

            $result['success'] = true;
        }
        catch (Exception $ex) {

        }

        return is_int($result_db) && $result_db > 0 ? true : false; // returning boolean

        return json_encode($result);
    }

    // read
    //public function readPackages() {}
    public function getPackages() {
        $packages = array();

        try
        {
            $sSQL = "SELECT * FROM $this->table_name WHERE blog_id=$this->current_blog_id ORDER BY custom_order ASC";
            $result = $this->db->get_results($sSQL);

            foreach($result as $row) {
                $packages[] = Package::withRow($row);
            }
        }
        catch(Exception $ex) {

        }

        // return array of objects
        return $packages;
    }

    // update

    public function deletePackage($id) {

        $result = false;

        try
        {
            //$sSQL = "DELETE FROM $table_name WHERE blog_id=$current_blog_id AND id=$id";
            $result = $this->db->delete($this->table_name, array(
                'id' => $id,
                'blog_id' => $this->current_blog_id
            ));
        }
        catch(Exception $ex) {

        }

        return is_int($result) && $result > 0 ? true : false;
    }

}