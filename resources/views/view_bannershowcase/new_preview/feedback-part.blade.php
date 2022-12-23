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
            <div id="feedbackInfo">
                <label for="feedbackInfo" id="feedbackLabel"></label>
            </div>
            <div id="bannerShowcase">
                <div class="single-div">
                    <div class="bannerResSize flex justify-between">
                        <small style="float: left;" id="bannerRes"></small>
                        <small class="float: right; text-red-700" id="bannerSize"></small>
                    </div>
                    
                    <iframe></iframe>
                </div>
            </div>
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

        function assignBanners(feedbackValue, categoryValue){
            axios.get('/getBannersData/'+ feedbackValue + '/' + categoryValue)
            .then(function (response) {
                // handle success
                console.log(response.data);
                $.each(response.data, function (key, value) {
                    var resolution = value.size_id;
                    var bannerPath = '/showcase_collection/' + value.file_path + '/index.html';
                    var sizeText = value.width;
                    $('#bannerRes').html((value.width + 'x' + value.height));
                    $('#bannerSize').html(value.size);
                    $("#bannerShowcase iframe").attr({'src':bannerPath,'height': value.height,'width': value.width, 'id': 'rel'+value.id});
                });
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
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
