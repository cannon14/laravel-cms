<?php
/**
 * Name: Basic Page
 * Type: pages
 * Description: Basic Page
 * Version: 1.0.0
 * Date: 2015-11-20
 */
?>

@extends('cccomus.templates.layouts.master')


@section('title', 'Careers at CreditCards.com')

@section('styles')

@endsection

@section('scripts')

@endsection

@section('content')

   {!! $page->post_content !!}

@endsection

