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

    public function createPackage() {

        $result = array('success' => false );

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

        header('Content-type: application/json');
        return json_encode($result);
    }

}
