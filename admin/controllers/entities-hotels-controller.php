<?php

/**
 * Class EntitiesHotelsController
 */
class EntitiesHotelsController extends MasterController
{
    private $hotelRepository;

    public function __construct()
    {
        $this->hotelRepository = HotelRepository::getInstance();

        add_action('wp_ajax_entities_hotels_controller', array($this, 'ajax'));
        add_action('wp_ajax_nopriv_entities_hotels_controller', array($this, 'ajax'));
    }

    public function ajax()
    {
        if ( isset( $_POST['type'] ) ) {

            $action = $_POST['type'];

            switch ($action) {
                case "createHotel":
                    echo $this->createHotel();
                    break;
                case "getHotels":
                    echo $this->getHotels(true);
                    break;
                case "updateHotel":
                    if ( isset( $_POST['id'] ) ) {
                        echo $this->updateHotel($_POST['id']);
                    }
                    break;
                case "updateGridHotel":
                    echo $this->updateGridHotel();
                    break;
                case "deleteHotel":
                    if ( isset( $_POST['id'] ) ) {
                        $this->deleteHotel($_POST['id']);
                    }
                    break;
                default:
                    parent::ajax();
                    break;
            }
        }

        exit;
    }

    /**
     * @return false|string
     */
    public function createHotel() {

        $response = array('success' => false);

        $hotel = new Hotel();
        $hotel->setStatus( $_POST['status'] );
        $hotel->setName( $_POST['name'] );
        $hotel->setShortDescription( $_POST['short_description'] );
        $hotel->setDescription( $_POST['description'] );
        $hotel->setFeaturedImage( $_POST['featured_image'] );
        $hotel->setObservations( $_POST['observations'] );
        $hotel->setCustomOrder( $_POST['custom_order'] );
        $hotel->setPrice( $_POST['price'] );

        $result = $this->hotelRepository->add($hotel);
        if ( $result ) {
            $response['success'] = true;
        }

        header('Content-type: application/json');
        return json_encode($response);
    }

    /**
     * @param $id
     * @param bool $json_encode
     * @return Activity|false|string|null
     */
    public function getHotelById($id, $json_encode=false) {

        $hotel = $this->hotelRepository->findById($id);

        if ( $json_encode ) {
            header('Content-type: application/json');
            return json_encode($hotel);
        }

        return $hotel;
    }

    /**
     * @param bool $json_encode
     * @return array|false|string
     */
    public function getHotels($json_encode=false) {

        $hotels = $this->hotelRepository->findAll();

        if ( $json_encode ) {
            header('Content-type: application/json');
            return json_encode($hotels);
        }

        return $hotels;
    }

    /**
     * @param $id
     * @return false|string
     */
    public function updateHotel($id) {

        $response = array('success' => false);

        $hotel = new Hotel();
        $hotel->setId( $id );
        $hotel->setStatus( $_POST['status'] );
        $hotel->setName( $_POST['name'] );
        $hotel->setShortDescription( $_POST['short_description'] );
        $hotel->setDescription( $_POST['description'] );
        $hotel->setFeaturedImage( $_POST['featured_image'] );
        $hotel->setObservations( $_POST['observations'] );
        $hotel->setCustomOrder( $_POST['custom_order'] );
        $hotel->setPrice( $_POST['price'] );

        $result = $this->hotelRepository->update($hotel);
        if ( $result ) {
            $response['success'] = true;
        }

        header('Content-type: application/json');
        return json_encode($response);

    }

    /**
     * @return false|string
     */
    public function updateGridHotel() {

        if ( isset( $_POST['hotel'] ) ) {
            $hotel_data = json_decode(stripslashes($_POST['hotel']));
            $hotel = Activity::withRow($hotel_data);

            $result = $this->hotelRepository->update($hotel);
            if ( $result ) {
                $response['success'] = true;
            }

            return json_encode($hotel);
        }

        exit;

    }

    /**
     * @param $id
     * @return false|string
     */
    public function deleteHotel($id) {

        $response = array('success' => false);

        $hotel = new Hotel();
        $hotel->setId($id);

        $result = $this->hotelRepository->remove($hotel);
        if ( $result ) {
            $response['success'] = true;
        }

        header('Content-type: application/json');
        return json_encode($response);

    }
}

new EntitiesHotelsController;