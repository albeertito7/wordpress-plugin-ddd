<?php

//require_once plugin_dir_path( dirname( __FILE__ ) ) . '../admin/class/Package.php';

/**
 * Class PackageRepository
 *
 * As much as is logical and efficient, a given DAO should limit its interaction
 * to the table or tables with which it is primarily concerned.
 *
 * SQL backed repository, not in memory.
 */
class PackageRepository extends MasterRepository {

    /** @var string */
    private $table_name;

    /**
     * PackageRepository constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->table_name= $this->db->prefix . 'entities_packages';
    }

    /*
    public function generateId(): ProductId {

    }*/

    /**
     * @param $package
     * @return bool
     */
    public function add($package) {

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
        }
        catch (Exception $ex) {

        }

        return is_int($result_db) && $result_db > 0 ? true : false; // returning boolean or object created
    }

    /**
     * @param $package
     * @return bool
     */
    public function remove($package) {
        $result_db = false;

        try
        {
            $result_db = $this->db->delete($this->table_name, array(
                'id' => $package->getId(),
                'blog_id' => $this->current_blog_id
            ));
        }
        catch(Exception $ex) {

        }

        return is_int($result_db) && $result_db > 0 ? true : false;
    }

    /**
     * @param $package
     * @return bool
     */
    public function update($package) {

        // data: status, name, short_description, description, featured_image, observations, custom_order, price
        $result_db = false;

        try {

            $result_db = $this->db->update($this->table_name,
                array(
                    //'author_id' => $package->getAuthorId(),
                    'status' => $package->getStatus(),
                    'name' => $package->getName(),
                    'short_description' => $package->getShortDescription(),
                    'description' => $package->getDescription(),
                    'price' => $package->getPrice(),
                    'featured_image' => $package->getFeaturedImage(),
                    'custom_order' => $package->getCustomOrder(),
                    'observations' => $package->getObservations()
                ),
                array(
                    'id' => $package->getId(),
                    'blog_id' => $this->current_blog_id
                ));
        }
        catch (Exception $ex) {

        }

        return is_int($result_db) && $result_db > 0 ? true : false; // returning boolean or object created

    }

    /**
     * @param $id
     * @return Package|null
     */
    public function findById($id) {

        $package = null;

        try
        {
            $sSQL = "SELECT * FROM $this->table_name WHERE blog_id=$this->current_blog_id AND id=$id";
            $result = $this->db->get_results($sSQL);

            if ($result instanceof Object && $result != null) {
                $package = Package::withRow($result);
            }
        }
        catch(Exception $ex) {
            //throw new OutOfBoundsException(sprintf('Package with id: %d, does not exist', $id->toInt()), 0, $ex);
        }

        return $package;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function findAll() {

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

        return $packages;
    }

    /**
     * @return int
     */
    public function size() {

        $result_db = 0;

        try {
            $sSQL = "SELECT COUNT(*) FROM $this->table_name WHERE blog_id=$this->current_blog_id";
            $result_db = $this->db->get_var($sSQL);
        }
        catch(Exception $ex) {

        }

        return is_int($result_db) && $result_db >= 0 ? $result_db : 0;

    }

    /**
     * @return bool
     */
    public function isEmpty() {
        return $this->size() == 0 ? true : false;
    }

}
