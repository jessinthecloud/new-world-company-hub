@extends('errors.layout')

@section('title', __('Forbidden'))

@section('message', __($exception->getMessage() ?: 'Forbidden'))
