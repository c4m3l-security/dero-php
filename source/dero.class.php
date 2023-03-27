<?php

namespace Dero;

use GuzzleHttp\Client;

class DeroMerchant {

    private string $address;
    private string $port;
    private Client $httpClient;

    function __construct(string $address, string $port) {
        $this->address = $address;
        $this->port = $port;
        $this->httpClient = new Client(['base_uri' => "http://{$this->address}:{$this->port}/"]);
    }

    private function request(string $method, $params = null, $verb = 'POST', $path = 'json_rpc') {
        $data = [
            'jsonrpc' => '2.0',
            'id' => '1',
            'method' => $method
        ];

        if ($params) {
            $data['params'] = $params;
        }

        $options = [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'json' => $data
        ];

        $response = $this->httpClient->request($verb, $path, $options);

        return json_decode($response->getBody(), true);
    }

    public function getaddress() {
        return $this->request('getaddress');
    }

    public function getbalance() {
        return $this->request('getbalance');
    }

    public function getheight() {
        return $this->request('getheight');
    }

    public function transfer(int $amount, string $address, int $Mixin = 6, string $payment_id = '') {
        $params = compact('amount', 'address', 'Mixin', 'payment_id');

        return $this->request('transfer', $params);
    }

    public function get_bulk_payments(string $payment_ids, int $min_block_height) {
        $params = compact('payment_ids', 'min_block_height');

        return $this->request('get_bulk_payments', $params);
    }

    public function query_key(string $key_type) {
        $params = compact('key_type');

        return $this->request('get_bulk_payments', $params);
    }

    public function make_integrated_address(string $payment_id) {
        $params = compact('payment_id');

        return $this->request('make_integrated_address', $params);
    }

    public function split_integrated_address(string $integrated_address) {
        $params = compact('integrated_address');

        return $this->request('split_integrated_address', $params);
    }

    public function get_transfer_by_txid(string $txid) {
        $params = compact('txid');

        return $this->request('get_transfer_by_txid', $params);
    }

    public function get_transfers(bool $In = true, bool $Out = true, int $Min_Height = 0, int $Max_Heigh = 0) {
        $params = compact('In', 'Out', 'Min_Height', 'Max_Heigh');

        return $this->request('get_transfers', $params);
    }
}
