<script src="https://code.jquery.com/jquery-3.6.3.slim.min.js" integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/js/all.min.js" integrity="sha512-rpLlll167T5LJHwp0waJCh3ZRf7pO6IT1+LZOhAyP6phAirwchClbTZV3iqL3BMrVxIYRbzGTpli4rfxsCK6Vw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<div>
    <?php $i=1; ?>
    
    <div class="container mx-auto px-4 py-3">
        <div id="tabs">
            @foreach ($data as $id => $row)
            <div id="version{{$id}}" class="versions @if(Helper::getFeedbackStatus($id) == 1) active @endif">
                {{ $i++ }}.{{ Helper::getFeedbackName($id) }}</div>
            @endforeach
        </div>

        <div id="bannershow" class="relative">
            <div id="feedbackInfo"><label for="feedbackInfo" id="feedbackLabel"></label></div>
            <div style="z-index: 999; display: flex; flex-direction: row; flex-wrap: nowrap; justify-content: space-between;">
                <div id="feedbacks" style="float: left; margin-left: 0.5rem;"></div>
                <div id="feedbackSettings" style="float: right; margin-right: 0.5rem;"></div>
            </div>
            <div id="banners" class="container mx-auto px-4 py-2"></div>
            <br>
        </div>
    </div>

    <script>
        var header = document.getElementById("tabs");
        var btns = header.getElementsByClassName("versions");
        var isOpenVersion = document.querySelector('.active').id;
        var viewFeedback = false;
        getCategoryData(isOpenVersion);
        getFeedbackData(isOpenVersion);

        for (var i = 0; i < btns.length; i++) {
            btns[i].addEventListener("click", function () {
                document.getElementById('loaderArea').style.display = 'block';
                let versionId = this.id;

                var current = document.getElementsByClassName("active");
                current[0].className = current[0].className.replace(" active", "");
                this.className += " active";

                getCategoryData(versionId);
                getFeedbackData(versionId);
            });
        }

        function getCategoryData(id){
            console.log('Current active Version: ' + id);
            assignFeedbackName(id);
            assignFeedbackSettings(id);

            axios.get('/getFeedbackcategoryCount/' + id)
            .then(function (response) {
                // handle success

                const categoryCount = response.data;

                axios.get('/getCategoryData/'+ {{ $main_project_id }} + '/' + id)
                .then(function (response) {
                    // handle success
                    row = '';
                    $.each(response.data, function (key, category){
                        axios.get('/getBannersData/' + category.id)
                        .then(function (response) {
                            // handle success

                            $.each(response.data, function (key, value) {
                                if(categoryCount > 1){
                                    row = row + '<div id="categoryName">';
                                        row = row + '<div style="width: 100%; height: auto; display: flex; flex-wrap: nowrap; color: white; text-align: center; justify-content: center; background:{{ $main_project_info['color'] }}; padding: 5px 5px 5px 5px; border-radius: 8px;">'+ category.name +'</div>';
                                    row = row + '</div>';
                                }
                                
                                var resolution = value.size_id;
                                var bannerPath = '/showcase_collection/' + value.file_path + '/index.html';
                                var bannerReloadID = value.id;
                                
                                row = row + '<div id="bannerShowcase">';
                                    row = row + '<div style="display: inline-block; width: '+ value.width +'px; margin-right: 10px;">';
                                        row = row + '<div style="display: flex; justify-content: space-between;">';
                                            row = row + '<small style="float: left;" id="bannerRes">'+ value.width + 'x' + value.height +'</small>';
                                            row = row + '<small class="float: right; text-red-700" id="bannerSize">'+ value.size +'</small>';
                                        row = row + '</div>';
                                        row = row + '<iframe src="'+ bannerPath +'" width="'+ value.width +'" height="'+ value.height +'" frameBorder="0" scrolling="no" id='+ "rel" + value.id +'></iframe>'
                                        row = row + '<ul style="display: flex; color:{{ $main_project_info['color'] }}; flex-direction: row;">';
                                            row = row + '<li><i id="relBt'+ value.id +'" onClick="reload('+ bannerReloadID +')" class="fa-solid fa-rotate" style="display: flex; margin-top: 0.5rem; cursor: pointer; font-size:20px;"></i></li>';
                                                row = row + '@if(Auth::check()) @if(Auth::user()->company_id == 7) @else'
                                                    row = row + '<li><a href="/showcase/edit/'+ value.id +'"><i class="fa-solid fa-pen-to-square" style="display: flex; margin-top: 0.5rem; margin-left: 0.5rem; font-size:20px;"></i></a></li>';
                                                    row = row + '<li><a href="/showcase/download/'+ value.id +'"><i class="fa-solid fa-cloud-arrow-down" style="display: flex; margin-top: 0.5rem; margin-left: 0.5rem; font-size:20px;"></i></a></li>';
                                                    row = row + '<li><a href="/showcase/delete/'+ value.id +'" onclick="return confirmDeleteBanner()"><i class="fa-solid fa-trash" style="display: flex; margin-top: 0.5rem; margin-left: 0.5rem; font-size:20px;"></i></a></li>';
                                                row = row + '@endif';
                                            row = row + '@endif';
                                        row = row + '</ul>';
                                    row = row + '</div>';
                                row = row + '</div>';
                                row = row + '<br>';
                            });
                            $('#banners').html(row);

                        })
                        .catch(function (error) {
                            // handle error
                            console.log(error);
                        })
                        .finally(function(){
                            document.getElementById('loaderArea').style.display = 'none';
                        })
                    });
                    
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
        }

        function getFeedbackData(id){
            axios.get('/getFeedbackData/'+ {{ $main_project_id }} + '/' + id)
            .then(function (response) {
                // handle success
                assignFeedbacks(response.data.description);
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
        }

        function assignFeedbacks(data){
            rows = '';

            rows = rows + '<div id="feedbackDescription" style="position: absolute; display: none; opacity: 0; width: 350px; height auto; top: -25%; left: -25%; z-index: 9999; margin-top: 0.5rem; margin-left: 0.5rem;">'
                rows = rows + '<div style="position: absolute; width: 100%; height: auto; padding: 2px 2px 2px 2px; background-color: {{ $main_project_info['color'] }}; border-top-left-radius: 10px; border-top-right-radius: 10px;">';
                    rows = rows + '<div style="float: left; color: white; font-size:16px;">';
                        rows = rows + '<label style="margin-left: 0.25rem;">The following feedbacks are implemented:</label>';
                    rows = rows + '</div>';
                    rows = rows + '<div style="float: right; font-size:16px;">';
                        rows = rows + '<div onClick="feedbackDisappear();" style="cursor: pointer; display: flex; margin-right: 0.5rem; margin-top: 0.2rem; align-items: center; text-align: center; justify-content: center; background: white; border-radius: 50%; width: 20px; height: 20px; transform-origin: center; color: {{ $main_project_info['color'] }};"><i class="fa-solid fa-xmark"></i></div>';
                    rows = rows + '</div>';
                rows = rows + '</div>';

                rows = rows + '<br>';

                rows = rows + '<div style="word-wrap: break-word; white-space: pre-line; background-color: rgb(217, 218, 227);  border-bottom-right-radius: 10px;  border-bottom-left-radius: 10px;">';
                    rows = rows + '<div style="padding: 0.5rem;"><span>' + data + '</span></div>';
                rows + rows + '</div>';

                rows = rows + '</div>';
            rows = rows + '</div>';

            rows = rows + '<div style="text-decoration: underline; cursor: pointer;" onClick="feedbackAppear();">';
                rows = rows + 'View Changes';
            rows = rows + '</div>';

            $('#feedbacks').html(rows);
        }

        function assignFeedbackSettings(id){
            var ret = id.replace('version','');
            restURL = {{$main_project_id}} + '/' + ret;

            rows = '';
            
            rows = rows + '<div>';
                rows = rows + '@if(Auth::check())';
                    rows = rows + '@if(Auth::user()->company_id == 7) ';
                    rows = rows + '@else';
                        rows = rows + '<div style="display: flex; color:{{ $main_project_info['color'] }}; font-size:25px;">';
                            rows = rows + '<a href="/banner/add/feedback/'+ restURL +'" style="margin-right: 0.5rem;"><i class="fa-solid fa-plus"></i></a>';
                            rows = rows + '<a href="/banner/edit/feedback/'+ restURL +'" style="margin-right: 0.5rem;"><i class="fa-solid fa-pen-to-square"></i></a>';
                            rows = rows + '<a href="/banner/delete/feedback/'+ restURL +'" onclick="return confirmDeleteFeedback()"><i class="fa-solid fa-trash"></i></a>';
                        rows = rows + '</div>';
                    rows = rows + '@endif';
                rows = rows + '@endif';
            rows = rows + '</div>';

            $('#feedbackSettings').html(rows);
        }

        function assignBanners(categoryValue){
            axios.get('/getBannersData/' + categoryValue)
            .then(function (response) {
                // handle success
                console.log(response.data);
                var row = '';

                $.each(response.data, function (key, value) {
                    var resolution = value.size_id;
                    var bannerPath = '/showcase_collection/' + value.file_path + '/index.html';
                    var bannerReloadID = value.id;
                    
                    row = row + '<div id="bannerShowcase">';
                    row = row + '<div style="display: inline-block; width: '+ value.width +'px; margin-right: 10px;">';
                        row = row + '<div style="display: flex; justify-content: space-between;">';
                            row = row + '<small style="float: left;" id="bannerRes">'+ value.width + 'x' + value.height +'</small>';
                            row = row + '<small class="float: right; text-red-700" id="bannerSize">'+ value.size +'</small>';
                        row = row + '</div>';
                        row = row + '<iframe src="'+ bannerPath +'" width="'+ value.width +'" height="'+ value.height +'" frameBorder="0" scrolling="no" id='+ "rel" + value.id +'></iframe>'
                        row = row + '<ul style="display: flex; color:{{ $main_project_info['color'] }}; flex-direction: row;">';
                            row = row + '<li><i id="relBt'+ value.id +'" onClick="reload('+ bannerReloadID +')" class="fa-solid fa-rotate" style="display: flex; margin-top: 0.5rem; cursor: pointer; font-size:20px;"></i></li>';
                                row = row + '@if(Auth::check()) @if(Auth::user()->company_id == 7) @else'
                                    row = row + '<li><a href="/showcase/edit/'+ value.id +'"><i class="fa-solid fa-pen-to-square" style="display: flex; margin-top: 0.5rem; margin-left: 0.5rem; font-size:20px;"></i></a></li>';
                                    row = row + '<li><a href="/showcase/download/'+ value.id +'"><i class="fa-solid fa-cloud-arrow-down" style="display: flex; margin-top: 0.5rem; margin-left: 0.5rem; font-size:20px;"></i></a></li>';
                                    row = row + '<li><a href="/showcase/delete/'+ value.id +'" onclick="return confirmDeleteBanner()"><i class="fa-solid fa-trash" style="display: flex; margin-top: 0.5rem; margin-left: 0.5rem; font-size:20px;"></i></a></li>';
                                row = row + '@endif';
                            row = row + '@endif';
                        row = row + '</ul>';
                    row = row + '</div>';
                    row = row + '</div>';
                });

                $('#banners').append(row);
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
        }

        function reload(bannerReloadID) {
            document.getElementById("rel"+bannerReloadID).src += '';
        }

        function assignFeedbackName(value){
            axios.get('/getFeedbackName/'+ value)
            .then(function (response){
                $('#feedbackLabel').html(response.data);
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
        }

        function confirmDeleteBanner() {
            return confirm('SLOW DOWN HOTSHOT! Are you sure you want to delete this banner?!');
        }

        function confirmDeleteFeedback(){
            return confirm('SLOW DOWN HOTSHOT! Are you sure you want to delete this feedback?!');
        }

        function feedbackAppear(){
            viewFeedback = true;
            var except = document.getElementById('feedbackDescription');
            var tl = gsap.timeline();

            tl
            .to('#feedbackDescription', {duration: 0.5, top: 0, left: 0, opacity: 1, display: 'block', ease: 'power3.out'});

            if(viewFeedback == true){
                document.addEventListener('click', closeThisFeedback, true);
                function closeThisFeedback(e){
                    if ( !except.contains(e.target) ) { //if the clicked element is the feedback div then it wont disappear
                        tl
                        .to('#feedbackDescription', {duration: 0.5, top: '-25%', left: '-25%', opacity: 0, display: 'none', ease: 'power3.in'});
                    }
                }
                viewFeedback = false;
            }
        }

        function feedbackDisappear(){
            var tl = gsap.timeline();

            tl
            .to('#feedbackDescription', {duration: 0.5, top: '-25%', left: '-25%', opacity: 0, display: 'none', ease: 'power3.in'});

            viewFeedback = false;
        }

    </script>
</div>
