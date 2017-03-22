<?php

/**
 * @api {post} /customers/my/addresses POST Create new address
 * @apiName PostAddress
 * @apiGroup Address
 * @apiVersion 0.0.1
 *
 * @apiDescription Creates new address for a customer accosiated with the token.
 *
 * @apiParam {String} street Street
 * @apiParam {String} city City
 * @apiParam {String} zip_code Zip-code
 * @apiParam {String} state State ISO2 code
 * @apiParam {String} country Country ISO2 code
 *
 * @apiSuccess {Object[]} addresses List user of addresses
 * @apiSuccess {String} addresses.street Street
 * @apiSuccess {String} addresses.city City
 * @apiSuccess {String} addresses.zip_code Zip-code
 * @apiSuccess {Object} addresses.state State
 * @apiSuccess {String} addresses.state.name Name of the state.
 * @apiSuccess {String} addresses.state.iso2 ISO2 code of the state.
 * @apiSuccess {Object} addresses.country Country
 * @apiSuccess {String} addresses.country.name Name of the country.
 * @apiSuccess {String} addresses.country.iso2 ISO2 code of the country.
 *
 * @apiSuccessExample Success-Response:
 * HTTP/1.1 201 CREATED
 * [{
 *      "street": "1825 Bryan Street",
 *      "city": "Lexington",
 *      "zip_code": "27292",
 *      "state": {
 *          "name": "North Carolina",
 *          "iso2": "NC"
 *      },
 *      "country" {
 *          "name": "United States",
 *          "iso2": "US"
 *      },
 *      "phone": 1736748834
 * },
 * {
 *      "street": "1825 Bryan Street",
 *      "city": "Lexington",
 *      "zip_code": "27292",
 *      "state": {
 *          "name": "North Carolina",
 *          "iso2": "NC"
 *      },
 *      "country" {
 *          "name": "United States",
 *          "iso2": "US"
 *      },
 *      "phone": 1736748834
 * }]
 */

/**
 * @api {get} /customers/my/addresses/:address_id GET Find address by ID
 * @apiName GetAddress
 * @apiGroup Address
 * @apiVersion 0.0.1
 *
 * @apiDescription Fetches address information by ID for a customer accosiated with the access token.
 *
 * @apiSuccess {String} street Street
 * @apiSuccess {String} city City
 * @apiSuccess {String} zip_code Zip-code
 * @apiSuccess {Object} state State
 * @apiSuccess {String} state.name Name of the state.
 * @apiSuccess {String} state.iso2 ISO2 code of the state.
 * @apiSuccess {Object} country Country
 * @apiSuccess {String} country.name Name of the country.
 * @apiSuccess {String} country.iso2 ISO2 code of the country.
 *
 * @apiSuccessExample Success-Response:
 * HTTP/1.1 200 OK
 * {
 *      "street": "1825 Bryan Street",
 *      "city": "Lexington",
 *      "zip_code": "27292",
 *      "state": {
 *          "name": "North Carolina",
 *          "iso2": "NC"
 *      },
 *      "country" {
 *          "name": "United States",
 *          "iso2": "US"
 *      },
 *      "phone": 1736748834
 * }
 */

/**
 * @api {put} /customers/my/addresses/:address_id PUT Modify address
 * @apiName PutAddress
 * @apiGroup Address
 * @apiVersion 0.0.1
 *
 * @apiDescription Modifies address found by unqiue ID and customer ID accosiated with the token.
 *
 * @apiParam {String} street Street
 * @apiParam {String} city City
 * @apiParam {String} zip_code Zip-code
 * @apiParam {String} state State ISO2 code
 * @apiParam {String} country Country ISO2 code
 *
 * @apiSuccess {String} street Street
 * @apiSuccess {String} city City
 * @apiSuccess {String} zip_code Zip-code
 * @apiSuccess {Object} state State
 * @apiSuccess {String} state.name Name of the state.
 * @apiSuccess {String} state.iso2 ISO2 code of the state.
 * @apiSuccess {Object} country Country
 * @apiSuccess {String} country.name Name of the country.
 * @apiSuccess {String} country.iso2 ISO2 code of the country.
 *
 * @apiSuccessExample Success-Response:
 * HTTP/1.1 200 OK
 * {
 *      "street": "1825 Bryan Street",
 *      "city": "Lexington",
 *      "zip_code": "27292",
 *      "state": {
 *          "name": "North Carolina",
 *          "iso2": "NC"
 *      },
 *      "country" {
 *          "name": "United States",
 *          "iso2": "US"
 *      },
 *      "phone": 1736748834
 * }
 */

/**
 * @api {delete} /customers/my/addresses/:address_id DELETE Remove address
 * @apiName DeleteAddress
 * @apiGroup Address
 * @apiVersion 0.0.1
 *
 * @apiDescription Removes address found by unqiue ID and customer ID accosiated with the token.
 *
 * @apiSuccessExample Success-Response:
 * HTTP/1.1 204 NO CONTENT
 */
