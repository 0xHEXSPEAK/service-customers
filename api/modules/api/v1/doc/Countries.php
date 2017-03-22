<?php

/**
 * @api {get} /countries GET Fetch countries list
 * @apiName GetCountries
 * @apiGroup Country
 * @apiVersion 0.0.1
 *
 * @apiDescription Request countries list
 *
 * @apiParam {Number} page=1 Use for pagination
 *
 * @apiSuccess {Object[]} object <code>Note</code>, that this index does not actually exists. Just to demonstrate nested structure.
 * @apiSuccess {Number} object.name Name of the country.
 * @apiSuccess {Number} object.iso2 ISO2 code of the country.
 * @apiSuccess {Object[]} object.states List of states.
 * @apiSuccess {String} object.states.name Name of the state.
 * @apiSuccess {String} object.states.iso2 ISO2 code of the state.
 *
 * @apiSuccessExample Success-Response:
 *  HTTP/1.1 200 OK
 *  [
 *      {
 *          "name": "United States",
 *          "iso2": "US"
 *          "states": [{
 *              "name": "New York",
 *              "iso2": "NY"
 *          },
 *          {
 *              "name": "Florida",
 *              "iso2": "FL"
 *          }]
 *      },
 *      {
 *          "name": "Ukraine",
 *          "iso2": "UA"
 *          "states": [{
 *              "name": "Kiev",
 *              "iso2": "KV"
 *          },
 *          {
 *              "name": "Mykolaiv",
 *              "iso2": "MY"
 *          }]
 *      }
 *   ]
 */

/**
 * @api {get} /countries/:id/states GET Find states by country
 * @apiName GetCountryStates
 * @apiGroup Country
 * @apiVersion 0.0.1
 *
 * @apiDescription Request states list filtered by country id
 *
 * @apiSuccess {Object[]} object <code>Note</code>, that this index does not actually exists. Just to demonstrate nested structure.
 * @apiSuccess {Number} object.name Name of the state.
 * @apiSuccess {Number} object.iso2 ISO2 code of the state.
 *
 * @apiSuccessExample Success-Response:
 *  HTTP/1.1 200 OK
 *  [
 *      {
 *          "name": "New York",
 *          "iso2": "NY"
 *      },
 *      {
 *          "name": "Florida",
 *          "iso2": "FL"
 *      }
 *  ]
 */
