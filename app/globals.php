<?php


function getUser() {
    return Auth::user();
}

function checkUser() {
    return Auth::check();
}

function getUserId() {
    return Auth::user()->id;
}