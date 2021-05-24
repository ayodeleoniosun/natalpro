@extends('template')

@section('title')
    Natalpro | Contact Us
@endsection

@section('content')
    <section class="inner-banner">
            <div class="container">
                <h2 class="inner-banner__title">Contact Us</h2><!-- /.inner-banner__title -->
                <ul class="thm-breadcrumb">
                    <li class="thm-breadcrumb__item"><a class="thm-breadcrumb__link" href="index-2.html">Home</a></li>
                    <li class="thm-breadcrumb__item current"><a class="thm-breadcrumb__link" href="contact.html">Contact Us</a></li>
                </ul><!-- /.thm-breadcrumb -->
            </div><!-- /.container -->
        </section><!-- /.inner-banner -->
        <section class="contact-one contact-one__contact-page">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="block-title">
                            <h2 class="block-title__title">Make Enquiries</h2><!-- /.block-title__title -->
                            <p class="block-title__text">To make any enquiries, please complete the form available below. </p><!-- /.block-title__text -->
                        </div><!-- /.block-title -->
                        <form class="contact-one__form contact-form-validated" id="contact-form" action="#" method="post"  onsubmit="return false">                            
                            <div class="row">
                                <div class="col-lg-12">
                                    <input type="text" name="fullname" placeholder="Full Name">
                                </div><!-- /.col-lg-12 -->
                                <div class="col-lg-12">
                                    <input type="email" name="email" placeholder="Email Address">
                                </div><!-- /.col-lg-12 -->
                                <div class="col-lg-12">
                                    <input type="text" name="phone" placeholder="Phone">
                                </div><!-- /.col-lg-12 -->
                                <div class="col-lg-12">
                                    <textarea placeholder="Message" name="message"></textarea>
                                </div><!-- /.col-lg-12 -->
                                <div class="col-lg-12">

                                    <button type="submit" id="contact-btn" onclick="return ajaxFormRequest('#contact-btn','#contact-form','process?SendFeedback','POST','#contact-status','Send Message','no')" class="btn btn-primary"><i class="fa fa-location-arrow"></i> Submit Now</button>
                                    <br/><br/>

                                    <div align="center" id="contact-status"> </div>
<!-- /.col-lg-12 -->
                                </div>

                            </div><!-- /.row -->
                        </form>
                    </div><!-- /.col-lg-7 -->
                    <div class="col-lg-5 ">
                        <div class="contact-one__page-content">
                            <div class="contact-one__page-widget">
                                <i class="contact-one__page-widget__icon icon icon-Pointer"></i>
                                <h3 class="contact-one__page-widget__title">Address :</h3><!-- /.contact-one__page-widget__title -->
                                <p class="contact-one__page-widget__text">Lagos, Nigeria</p><!-- /.contact-one__page-widget__text -->
                            </div><!-- /.contact-one__page-widget -->
                            <div class="contact-one__page-widget">
                                <i class="contact-one__page-widget__icon icon icon-Phone2"></i>
                                <h3 class="contact-one__page-widget__title">Phone :</h3><!-- /.contact-one__page-widget__title -->
                                <p class="contact-one__page-widget__text"><a href="tel:+2348063712314">+2348063712314</p><!-- /.contact-one__page-widget__text -->
                            </div><!-- /.contact-one__page-widget --> <br/>
                            <div class="contact-one__page-widget">
                                <i class="contact-one__page-widget__icon icon icon-Plaine"></i>
                                <h3 class="contact-one__page-widget__title">Email : </h3><!-- /.contact-one__page-widget__title -->
                                <p class="contact-one__page-widget__text"><a href="mailto:contact@dentallox.com">support@natalpro.org</a></p><!-- /.contact-one__page-widget__text -->
                            </div>
                            <div class="contact-one__page-widget">
                                <h3 class="contact-one__page-widget__title">We are social</h3><!-- /.contact-one__page-widget__title -->
                                <p class="contact-one__page-widget__text">
                                    <a href="http://www.facebook.com/natalproo" target="_blank"><i class="fa fa-facebook-f"></i></a> &nbsp; &nbsp;

                                    <a href="http://www.twitter.com/natalnurse" target="_blank"><i class="fa fa-twitter"></i></a>  &nbsp; &nbsp;

                                    <a href="http://www.instagram.com/natalnurse" target="_blank"><i class="fa fa-instagram"></i></a>

                                </p><!-- /.contact-one__page-widget__text -->
                            </div><!-- /.contact-one__page-widget -->
                        </div><!-- /.contact-one__page-content -->
                    </div><!-- /.col-lg-5 -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section><!-- /.contact-one -->
        <section class="contact-map">
            <div class="container">
                <div class="block-title">
                    <h2 class="block-title__title">How to Locate Us</h2><!-- /.block-title__title -->
                </div>
                <div class="mapouter"><div class="gmap_canvas">
                <iframe width="1024" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=lagos&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" ></iframe><a href="https://www.embedgooglemap.net/blog/nordvpn-coupon-code/">us internet discount code</a></div><style>.mapouter{position:relative;text-align:right;height:500px;width:1024px;}.gmap_canvas {overflow:hidden;background:none!important;height:500px;width:1024px;}</style></div>
            </div><!-- /.container -->
        </section><!-- /.contact-map -->
        <section class="cta-two">
            <div class="container">
                <h2 class="cta-two__title">Wants to request for our vaccination reminder?  <br/> 
                    <a href="{{ route('vaccination.add') }}" class="thm-btn cta-one__btn"><i class="fa fa-user-plus"></i> Register Now</a>
            </div><!-- /.container -->
        </section><!-- /.cta-two -->
@endsection
