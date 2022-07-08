<?php

//require_once plugin_dir_path( dirname( __FILE__ ) ) . '../admin/class/Package.php';

/**
 * Class PackageRepository
 *
 * As much as is logical and efficient, a given DAO should limit its interaction
 * to the table or tables with which it is primarily concerned.
 */
class PackageRepository extends MasterRepository {

    private $table_name;

    public function __construct()
    {
        parent::__construct();

        $this->table_name= $this->db->prefix . 'entities_packages';
    }

    /**
     * @param $package
     * @return bool|false|string
     *
     * insert db
     */
    public function createPackage($package) {

        // data: status, name, short_description, description, featured_image, observations, custom_order, price
        $result = array('success' => false );

        $result_db = false;

        try {

            $result_db = $this->db->insert($this->table_name, array(
                'blog_id' => $this->current_blog_id,
                'status' => $package->getStatus(),
                'name' => $package->getName(),
                'short_description' => $package->getShortDescription(),
                'description' => $package->getDescription(),
                'featured_image' => $package->getFeaturedImage(),
                'observations' => $package->getObservations(),
                'custom_order' => $package->getOrder(),
                'price' => $package->getPrice()
            ));

            $result['success'] = true;
        }
        catch (Exception $ex) {

        }

        return is_int($result_db) && $result_db > 0 ? true : false; // returning boolean or object created
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
            throw new Exception( '' );
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
            throw new Exception( '' );
        }

        return is_int($result) && $result > 0 ? true : false;
    }

    public function create($package)
    {
        // TODO: Implement create() method.
    }

    public function read($id)
    {
        // TODO: Implement read() method.
    }

    public function update($package)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }
}
