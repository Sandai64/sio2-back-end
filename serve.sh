#!/bin/bash

# Helper script for my dev machine
sudo killall httpd
sudo /opt/lampp/xampp start
symfony serve
