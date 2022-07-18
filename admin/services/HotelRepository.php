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
class HotelRepository extends MasterRepository {

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

        $this->table_name= $this->db->prefix . 'entities_hotels';
    }

    /**
     * @return HotelRepository
     * Singleton pattern for the Hotel repository.
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
     * @param $hotel
     * @return bool
     */
    public function add($hotel) {

        $result_db = false;

        try {

            $result_db = $this->db->insert($this->table_name, array(
                'blog_id' => $this->current_blog_id,
                'status' => $hotel->getStatus(),
                'name' => $hotel->getName(),
                'short_description' => $hotel->getShortDescription(),
                'description' => $hotel->getDescription(),
                'featured_image' => $hotel->getFeaturedImage(),
                'observations' => $hotel->getObservations(),
                'custom_order' => $hotel->getCustomOrder(),
                'price' => $hotel->getPrice()
            ));
        }
        catch (Exception $ex) {

        }

        return is_int($result_db) && $result_db > 0 ? true : false; // returning boolean or object created
    }

    /**
     * @param $hotel
     * @return bool
     */
    public function remove($hotel) {

        $result_db = false;

        try
        {
            $result_db = $this->db->delete($this->table_name, array(
                'id' => $hotel->getId(),
                'blog_id' => $this->current_blog_id
            ));
        }
        catch(Exception $ex) {

        }

        return is_int($result_db) && $result_db > 0 ? true : false;
    }

    /**
     * @param $activity
     * @return bool
     */
    public function update($hotel) {

        // data: status, name, short_description, description, featured_image, observations, custom_order, price
        $result_db = false;

        try {

            $result_db = $this->db->update($this->table_name,
                array(
                    //'author_id' => $package->getAuthorId(),
                    'status' => $hotel->getStatus(),
                    'name' => $hotel->getName(),
                    'short_description' => $hotel->getShortDescription(),
                    'description' => $hotel->getDescription(),
                    'price' => $hotel->getPrice(),
                    'featured_image' => $hotel->getFeaturedImage(),
                    'custom_order' => $hotel->getCustomOrder(),
                    'observations' => $hotel->getObservations()
                ),
                array(
                    'id' => $hotel->getId(),
                    'blog_id' => $this->current_blog_id
                ));
        }
        catch (Exception $ex) {

        }

        return is_int($result_db) && $result_db > 0 ? true : false; // returning boolean or object created

    }

    /**
     * @return array
     */
    public function findAll() {

        $hotels = array();

        try
        {
            $sSQL = "SELECT * FROM $this->table_name WHERE blog_id=$this->current_blog_id ORDER BY custom_order ASC";
            $result = $this->db->get_results($sSQL);

            foreach($result as $row) {
                $hotels[] = Hotel::withRow($row);
            }
        }
        catch(Exception $ex) {

        }

        return $hotels;
    }

    /**
     * @param $id
     * @return Activity|null
     */
    public function findById($id) {

        $hotel = null;

        try
        {
            $sSQL = "SELECT * FROM $this->table_name WHERE blog_id=$this->current_blog_id AND id=$id";
            $result_db = $this->db->get_results($sSQL); // output: (array|object|null)

            if ($result_db && is_array($result_db) && count($result_db) == 1) {
                $hotel = Hotel::withRow($result_db[0]);
            }
        }
        catch(Exception $ex) {
            //throw new OutOfBoundsException(sprintf('Package with id: %d, does not exist', $id->toInt()), 0, $ex);
        }

        return $hotel;
    }
}
