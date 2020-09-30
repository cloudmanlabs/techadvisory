@extends('accentureViews.layouts.benchmark')
<div class="main-wrapper">
    <x-accenture.navbar activeSection="benchmark"/>
    <div class="page-wrapper">
        <div class="page-content">
            @include('accentureViews.benchmarkStructure')

            <div class="card">
                <div class="card-body">
                    <div style="float: left;">
                        <h3>Overview stuff</h3>
                        <br>
                        <p>datos recibidos: {{$example}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
