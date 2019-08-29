<footer>

    <div class="container">
        <div class="row">

            <div class="col-lg-4 col-md-6">
                <div class="footer-section">

                    <strong>{{ config('app.name') }}</strong>
                    <p class="copyright">Developed by <a href="https://www.facebook.com/leojewel0108?ref=bookmarks" target="_blank">Didarul Karim Jewel</a></p>
                    <ul class="icons">
                        <li><a href="https://www.facebook.com/leojewel0108?ref=bookmarks" target="_blank"><i class="ion-social-facebook-outline"></i></a></li>
                        <li><a href="https://twitter.com/iamjewel0108" target="_blank"><i class="ion-social-twitter-outline"></i></a></li>
                    </ul>

                </div><!-- footer-section -->
            </div>


            <!-- Categories-->

            <div class="col-lg-4 col-md-6">
                <div class="footer-section">
                    <h4 class="title"><b>CATAGORIES</b></h4>
                    <ul>
                        @foreach($categories as $category)
                            <li><a href="{{route('category.posts',$category->slug)}}">{{$category->name}}</a></li>
                        @endforeach

                    </ul>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="footer-section">

                    <h4 class="title"><b>SUBSCRIBE</b></h4>
                    <div class="input-area">
                        <form method="post" action="{{route('subscriber.store')}}">
                            @csrf
                            <input class="email-input" name="email" type="email" placeholder="Enter your email">
                            <button class="submit-btn" type="submit"><i class="icon ion-ios-email-outline"></i></button>
                        </form>
                    </div>

                </div><!-- footer-section -->
            </div><!-- col-lg-4 col-md-6 -->

        </div><!-- row -->
    </div><!-- container -->
</footer>
