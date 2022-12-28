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
            <div style="z-index: 999; display: flex; flex-direction: row; flex-wrap: nowrap; justify-content: space-between;" id="feedbackSettings"></div>
            <div id="bannerShowcase"></div>
            <br>
        </div>
    </div>

    <script>
        var header = document.getElementById("tabs");
        var btns = header.getElementsByClassName("versions");
        var isOpenVersion = document.querySelector('.active').id;
        getBannerData(isOpenVersion);

        for (var i = 0; i < btns.length; i++) {
            btns[i].addEventListener("click", function () {
                document.getElementById('loaderArea').style.display = 'block';
                let versionId = this.id;

                var current = document.getElementsByClassName("active");
                current[0].className = current[0].className.replace(" active", "");
                this.className += " active";

                getBannerData(versionId);
            });
        }

        function getBannerData(id){
            console.log('Current active Version: ' + id);

            axios.get('/getBannersForFeedback/'+ {{ $main_project_id }} + '/' + id)
            .then(function (response) {
                // handle success
                var rows = '';
                $.each(response.data, function (key, value) {
                    assignCategoryname(key);
                    assignFeedbackSettings(id);
                    assignBanners(id, key);
                });
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
            .finally(function(){
                document.getElementById('loaderArea').style.display = 'none';
            })
        }

        function assignFeedbackSettings(id){
            var ret = id.replace('version','');
            restURL = {{$main_project_id}} + '/' + ret;

            rows = '';

            rows = rows + '<div style="float: left; margin-left: 0.5rem;"><label>View Changes</label>';
            rows = rows + '</div>';
            rows = rows + '<div style="float: right; margin-right: 0.5rem;">';
            rows = rows + '@if(Auth::check())';
            rows = rows + '@if(Auth::user()->company_id == 7) ';
            rows = rows + '@else';
            rows = rows + '<div style="display: flex; color:{{ $main_project_info['color'] }}; font-size:25px;">';
            rows = rows + '<a href="/banner/add/feedback/'+ restURL +'" style="margin-right: 0.5rem;"><i class="fa-solid fa-plus"></i></a>';
            rows = rows + '<a href="/banner/edit/feedback/'+ restURL +'" style="margin-right: 0.5rem;"><i class="fa-solid fa-pen-to-square"></i></a>';
            rows = rows + '<a href="/banner/delete/feedback/'+ restURL +'"><i class="fa-solid fa-delete-left"></i></a>';
            rows = rows + '</div>';
            rows = rows + '@endif';
            rows = rows + '@endif';
            rows = rows + '</div>';

            

            $('#feedbackSettings').html(rows);
        }

        function assignBanners(feedbackValue, categoryValue){
            axios.get('/getBannersData/'+ feedbackValue + '/' + categoryValue)
            .then(function (response) {
                // handle success
                console.log(response.data);
                var row = '';

                $.each(response.data, function (key, value) {
                    var resolution = value.size_id;
                    var bannerPath = '/showcase_collection/' + value.file_path + '/index.html';
                    var bannerReloadID = value.id;
                    
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
                    row = row + '<li><a href="/showcase/delete/'+ value.id +'"><i class="fa-solid fa-trash" style="display: flex; margin-top: 0.5rem; margin-left: 0.5rem; font-size:20px;"></i></a></li>';
                    row = row + '@endif @endif';
                    row = row + '</ul>';
                    row = row + '</div>';
                });

                $('#bannerShowcase').html(row);
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
        }

        function reload(bannerReloadID) {
            document.getElementById("rel"+bannerReloadID).src += '';
        }

        function assignCategoryname(value){
            axios.get('/getCategoryName/'+ value)
            .then(function (response){
                $('#feedbackLabel').html(response.data);
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
        }

    </script>
</div>
