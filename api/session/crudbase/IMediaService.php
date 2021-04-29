<?php


interface IMediaService
{

    function findByCategory($category);

    function findByHashing($hash);

}