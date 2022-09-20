<?php

namespace Entities\Controllers;

/**
 * Class MasterController
 *
 * When a request arrives, it is routed by the framework to the exact controller.
 *
 * The controller is in charge of analyzing the request and calling the relevant services or DAOs (Data Access Objects),
 * the classes in charge of communicating with the database.
 *
 * Services are objects that perform some kind of computation. It can be on the "domain layer"
 * (i.e. computation that is directly related to the code of your application - what makes your application specific)
 * or it can be purely technical services (like a mailer, a logger, etc...).
 *
 * Finally, the controller aggregates data received from various services and calls a "view" that
 * will render the date in HTML (unless it is directly sent in another format like JSON).
 */
class MasterController
{
    /** @noinspection PhpSignatureMismatchDuringInheritanceInspection */
    public function ajax(/*Request request*/)
    {
        echo "Silence is golden";
        exit;
    }
}
