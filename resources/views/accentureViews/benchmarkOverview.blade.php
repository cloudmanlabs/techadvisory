@extends('accentureViews.layouts.benchmark')
<div class="main-wrapper">
    <x-accenture.navbar activeSection="benchmark"/>
    <div class="page-wrapper">
        <div class="page-content">

            <div class="row" id="benchmark-title-row">
                <div class="col-12 col-xl-12 stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div style="float: left;">
                                <h3>Welcome to Benchmark and Analytics</h3>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="profile-page" id="benchmark-nav-container">
                <div class="row" id="navs-container">
                    <div class="col-12 grid-margin">
                        @include('accentureViews.benchmarkStructure')
                        @include('accentureViews.benchmarkOverviewNavBar')
                    </div>
                </div>

                <div class="row" id="content-container">
                    <div class="col-12 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="row ">
                                    <aside id="overview-filters-container" class="col-4">
                                        <h4>Filters</h4>
                                        <br>
                                        <select>
                                            <option value="null" selected>Chose a Practice</option>
                                        </select>
                                        <br>
                                        <select>
                                            <option value="null" selected>Chose a Subpractice</option>
                                        </select>
                                        <br>
                                        <select>
                                            <option value="null" selected>Chose a Region</option>
                                        </select>
                                    </aside>
                                    <div id="overview-graphics-container" class="col-8 border-left " >
                                        <h4>Graphics</h4>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


</div>
