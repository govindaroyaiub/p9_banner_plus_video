<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://code.jquery.com/jquery-3.6.1.slim.min.js"
    integrity="sha256-w8CvhFs7iHNVUtnSP0YKEg00p9Ih13rlL9zGqvLdePA=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/js/all.min.js" integrity="sha512-rpLlll167T5LJHwp0waJCh3ZRf7pO6IT1+LZOhAyP6phAirwchClbTZV3iqL3BMrVxIYRbzGTpli4rfxsCK6Vw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<div id="bannershow" class="relative">
    <div id="feedbackInfo"><label for="feedbackInfo" id="feedbackLabel"></label></div>
    <div id="bannerShowcase"></div>
    <br>
</div>

<script>
    //first know the type of the project
    document.getElementById('loaderArea').style.display = 'block';

    $(document).ready(function(){
        checkType();
        getFeedbackName();
    });

    function checkType(){
        axios.get('/getProjectType/'+ {{ $main_project_id }})
        .then(function (response){
            if(response.data == 1){
                //project_type 1 == banner
                getBannersData();
            }
            else if(response.data == 2){
                //project_type 2 == video
                getVideoData();
            }
            else if(response.data == 3){
                //project_type 3 == gif
                getGifData();
            }
            else{
                //project_type 4 or else == social
                getSocialData();
            }
        })
        .catch(function (error) {
            console.log(error);
        })
    }
    
    function getFeedbackName(){
        axios.get('/getNewFeedbackName/'+ {{ $main_project_id }})
        .then(function (response){
            $('#feedbackLabel').html(response.data);
        })
        .catch(function (error) {
            console.log(error);
        })
    }

    function getBannersData(){
        axios.get('/getNewBannersData/'+ {{ $main_project_id }})
        .then(function (response){
            var row = '';

            $.each(response.data, function (key, value) {
                var resolution = value.size_id;
                var bannerPath = '/new_showcase_collection/' + value.file_path + '/index.html';
                var bannerReloadID = value.id;
                
                row = row + '<div style="display: inline-block; width: '+ value.width +'px; margin-right: 10px;">';
                    row = row + '<div style="display: flex; justify-content: space-between;">';
                        row = row + '<small style="float: left;" id="bannerRes">'+ value.width + 'x' + value.height +'</small>';
                        row = row + '<small class="float: right; text-red-700" id="bannerSize">'+ value.size +'</small>';
                    row = row + '</div>';
                    row = row + '<iframe src="'+ bannerPath +'" width="'+ value.width +'" height="'+ value.height +'" frameBorder="0" scrolling="no" id='+ "rel" + value.id +'></iframe>'
                    row = row + '<ul style="display: flex; color:{{ $info['color'] }}; flex-direction: row;">';
                        row = row + '<li><i id="relBt'+ value.id +'" onClick="reload('+ bannerReloadID +')" class="fa-solid fa-rotate" style="display: flex; margin-top: 0.5rem; cursor: pointer; font-size:20px;"></i></li>';
                            row = row + '@if(Auth::check()) @if(Auth::user()->company_id == 7) @else'
                                row = row + '<li><a href="/project/preview/banner/edit/'+ value.id +'"><i class="fa-solid fa-pen-to-square" style="display: flex; margin-top: 0.5rem; margin-left: 0.5rem; font-size:20px;"></i></a></li>';
                                row = row + '<li><a href="/project/preview/banner/download/'+ value.id +'"><i class="fa-solid fa-cloud-arrow-down" style="display: flex; margin-top: 0.5rem; margin-left: 0.5rem; font-size:20px;"></i></a></li>';
                                row = row + '<li><a href="javascript:void(0)" onclick="return confirmDeleteBanner('+ value.id +')"><i class="fa-solid fa-trash" style="display: flex; margin-top: 0.5rem; margin-left: 0.5rem; font-size:20px;"></i></a></li>';
                            row = row + '@endif';
                        row = row + '@endif';
                    row = row + '</ul>';
                row = row + '</div>';
            });

            $('#bannerShowcase').html(row);
        })
        .catch(function (error){
            console.log(error);
        })
        .finally(function(){
            document.getElementById('loaderArea').style.display = 'none';
        })
    }

    function confirmDeleteBanner(id) {
        if(confirm('SLOW DOWN HOTSHOT! Are you sure you want to delete this banner?!')){
            axios.get('/deleteBanner/'+ id)
            .then(function (response){
                if(response.data == 200){
                    getBannersData();
                }
            })
            .catch(function (error){
                console.log(error);
            })
        }
    }

    function reload(bannerReloadID) {
        document.getElementById("rel"+bannerReloadID).src += '';
    }

    function getVideoData(){
        console.log('Video');
    }

    function getGifData(){
        console.log('Gif');
    }

    function getSocialData(){
        console.log('Social');
    }
    
</script>