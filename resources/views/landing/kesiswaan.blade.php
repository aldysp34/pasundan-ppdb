@extends('layouts.landing')
 @section('description', 'SMAS PASUNDAN 3 adalah ....')
 @section('keywords','sman, sma bandung , bandung, sma negeri, sman, sma pasundan 3, sma pasundan, pasunan, negeri pasundan')

 @section('content')
 <!-- Error Area-->
 <!-- Welcome Area -->
 <div class="welcome-area bg-gradient">
     <!-- Background Shape -->
     <div class="background-shape">
         <div class="circle1 wow fadeInRightBig" data-wow-duration="4000ms"></div>
         <div class="circle2 wow fadeInRightBig" data-wow-duration="4000ms"></div>
         <div class="circle3 wow fadeInRightBig" data-wow-duration="4000ms"></div>
         <div class="circle4 wow fadeInRightBig" data-wow-duration="4000ms"></div>
     </div>
     <!-- Background Animation -->
     <div class="background-animation">
         <div class="item1"></div>
         <div class="item2"></div>
         <div class="item3"></div>
         <div class="item4"></div>
         <div class="item5"></div>
     </div>
     <div class="container h-100">
         <div class="row h-100 align-items-center justify-content-between">
             <!-- Welcome Content -->
             <div class="col-12 col-sm-10 col-md-6">
                 <div class="welcome-content">
                     <ul class="mb-0 ps-1 d-flex align-items-center wow fadeInUp" data-wow-duration="1s" data-wow-delay="200ms">
                         <li>Idea</li>
                         <li>Development</li>
                         <li>Branding</li>
                     </ul>
                     <h2 class="wow fadeInUp" data-wow-duration="1s" data-wow-delay="300ms">Halaman <br> Kesiswaan.</h2>
                     <p class="mb-4 wow fadeInUp" data-wow-duration="1s" data-wow-delay="400ms">It's crafted with the latest trend of design &amp; coded with all modern approaches.</p>
                     <div class="hero-btn-group wow fadeInUp" data-wow-duration="1s" data-wow-delay="500ms"><a class="btn btn-warning mt-3 me-3" href="#">Buy Now</a><a class="btn btn-light mt-3" href="#">See More</a></div>
                 </div>
             </div>
             <!-- Welcome Thumb -->
             <div class="col-12 col-sm-9 col-md-6">
                 <div class="welcome-thumb ms-xl-5" ><img src="{{ asset('assets/images/sma_simpenan_3_bdg.webp') }}" alt="sma pasundan 3"  style="max-height:450px;"></div>
             </div>
         </div>
     </div>
 </div>
 @endsection