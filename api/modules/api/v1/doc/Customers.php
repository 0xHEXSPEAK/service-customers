<?php

/**
 * @api {post} /customers POST Create new customer
 * @apiName PostCustomers
 * @apiGroup Customer
 * @apiVersion 0.0.1
 *
 * @apiDescription Create new customer account
 *
 * @apiParam {String} firstname First name of the customer.
 * @apiParam {String} lastname Last name of the customer.
 * @apiParam {String} email <code>required</code> Email of the customer (Will be used as login).
 * @apiParam {String} password  <code>required</code> Password.
 *
 * @apiSuccess {String} firstname First name of the customer.
 * @apiSuccess {String} lastname Last name of the customer.
 * @apiSuccess {String} email Email of the customer.
 * @apiSuccess {Object[]} addresses Empty list of the user addresses.
 *
 * @apiSuccessExample Success-Response:
 * HTTP/1.1 201 CREATED
 * {
 *      "firstname": "Adam",
 *      "lastname": "Hogan",
 *      "email": "user@example.com"
 *      "addresses": []
 * }
 */

/**
 * @api {get} /customers/:id GET Customer details
 * @apiName GetCustomers
 * @apiGroup Customer
 * @apiVersion 0.0.1
 *
 * @apiDescription Request customer details by ID
 *
 * @apiSuccess {String} first_name First name of the customer.
 * @apiSuccess {String} last_name Last name of the customer.
 * @apiSuccess {String} email Email of the customer.
 * @apiSuccess {Object} addresses List of the customer addresses.
 * @apiSuccess {Object} addresses.shipping Defaut shipping address.
 *
 * @apiSuccess {String} addresses.shipping.street Street
 * @apiSuccess {String} addresses.shipping.city City
 * @apiSuccess {String} addresses.shipping.zip_code Zip-code
 * @apiSuccess {Object} addresses.shipping.state State
 * @apiSuccess {String} addresses.shipping.state.name Name of the state.
 * @apiSuccess {String} addresses.shipping.state.iso2 ISO2 code of the state.
 * @apiSuccess {Object} addresses.shipping.country Country
 * @apiSuccess {String} addresses.shipping.country.name Name of the country.
 * @apiSuccess {String} addresses.shipping.country.iso2 ISO2 code of the country.
 *
 * @apiSuccess {Object} addresses.billing Defaut billing address.
 * @apiSuccess {String} addresses.billing.street Street
 * @apiSuccess {String} addresses.billing.city City
 * @apiSuccess {String} addresses.billing.zip_code Zip-code
 * @apiSuccess {Object} addresses.billing.state State
 * @apiSuccess {String} addresses.billing.state.name Name of the state.
 * @apiSuccess {String} addresses.billing.state.iso2 ISO2 code of the state.
 * @apiSuccess {Object} addresses.billing.country Country
 * @apiSuccess {String} addresses.billing.country.name Name of the country.
 * @apiSuccess {String} addresses.billing.country.iso2 ISO2 code of the country.
 *
 * @apiSuccess {Object[]} addresses.list List of all customer addresses.
 *
 * @apiSuccess {String} addresses.list.street Street
 * @apiSuccess {String} addresses.list.city City
 * @apiSuccess {String} addresses.list.zip_code Zip-code
 * @apiSuccess {Object} addresses.list.state State
 * @apiSuccess {String} addresses.list.state.name Name of the state.
 * @apiSuccess {String} addresses.list.state.iso2 ISO2 code of the state.
 * @apiSuccess {Object} addresses.list.country Country
 * @apiSuccess {String} addresses.list.country.name Name of the country.
 * @apiSuccess {String} addresses.list.country.iso2 ISO2 code of the country.
 *
 * @apiSuccessExample Success-Response:
 *  HTTP/1.1 200 OK
 * {
 *      "first_name": "Adam",
 *      "last_name": "Hogan",
 *      "email": "adamhogan@example.com",
 *      "addresses": {
 *          "shipping": {
 *              "street": "1825 Bryan Street",
 *              "city": "Lexington",
 *              "zip_code": "27292",
 *              "state": {
 *                  "name": "North Carolina",
 *                  "iso2": "NC"
 *              },
 *              "country" {
 *                  "name": "United States",
 *                  "iso2": "US"
 *              },
 *              "phone": 1736748834
 *          },
 *          "billing": {
 *              "street": "1825 Bryan Street",
 *              "city": "Lexington",
 *              "zip_code": "27292",
 *              "state": {
 *                  "name": "North Carolina",
 *                  "iso2": "NC"
 *              },
 *              "country" {
 *                  "name": "United States",
 *                  "iso2": "US"
 *              },
 *              "phone": 1736748834
 *          },
 *          "list": [{
 *              "street": "1825 Bryan Street",
 *              "city": "Lexington",
 *              "zip_code": "27292",
 *              "state": {
 *                  "name": "North Carolina",
 *                  "iso2": "NC"
 *              },
 *              "country" {
 *                  "name": "United States",
 *                  "iso2": "US"
 *              },
 *              "phone": 1736748834
 *          },{
 *              "street": "1825 Bryan Street",
 *              "city": "Lexington",
 *              "zip_code": "27292",
 *              "state": {
 *                  "name": "North Carolina",
 *                  "iso2": "NC"
 *              },
 *              "country" {
 *                  "name": "United States",
 *                  "iso2": "US"
 *              },
 *              "phone": 1736748834
 *          }]
 *      }
 * }
 */