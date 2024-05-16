<?php

namespace App\Enums;

enum RequestMethod {
    case GET;
    case POST;
    case PUT;
    case DELETE;
    case PATCH;
    case STORE;
}