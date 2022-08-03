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

    // singleton
    private $instance;

    /**
     * PackageRepository constructor.
     */
    protected function __construct()
    {
        try {
            parent::__construct();
        } catch (Exception $e) {
        }

        $this->table_name= $this->db->prefix . 'entities_packages';
    }

    /**
     * @return PackageRepository
     * Singleton pattern for the Package repository.
     */
    public static function getInstance() {

        if ( isset( $instance ) ) {
            return $instance;
        }

        return new self();
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
                'custom_order' => $package->getCustomOrder(),
                'price' => $package->getPrice()
            ));
        }
        catch (Exception $ex) {

        }

        return is_int($result_db) && $result_db > 0; // returning boolean or object created
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

        return is_int($result_db) && $result_db > 0;
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

        return is_int($result_db) && $result_db > 0; // returning boolean or object created

    }

    /**
     * @return array
     * @throws Exception
     */
    public function findAll(): array
    {

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
     * @param $id
     * @return Package|null
     */
    public function findById($id) {

        $package = null;

        try
        {
            $sSQL = "SELECT * FROM $this->table_name WHERE blog_id=$this->current_blog_id AND id=$id";
            $result_db = $this->db->get_results($sSQL); // output: (array|object|null)

            if ($result_db && is_array($result_db) && count($result_db) == 1) {
                $package = Package::withRow($result_db[0]);
            }
        }
        catch(Exception $ex) {
            //throw new OutOfBoundsException(sprintf('Package with id: %d, does not exist', $id->toInt()), 0, $ex);
        }

        return $package;
    }
}
