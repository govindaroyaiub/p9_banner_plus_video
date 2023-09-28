<div id="bannershow" class="relative">
    <div id="feedbackInfo"><label for="feedbackInfo" id="feedbackLabel"></label></div>
    <div style="z-index: 999; display: flex; flex-direction: row; flex-wrap: nowrap; justify-content: space-between; justify-content: center; padding: 10px;">
        <div id="feedbackSettings"></div>
    </div>
    <br>
    <div id="bannerShowcase"></div>
    <br>
</div>

<script>
    //first know the type of the project
    $(document).ready(function(){
        checkType();
    });

    function checkType(){
        axios.get('/getProjectType/'+ {{ $main_project_id }})
        .then(function (response){
            if(response.data.project_type == 1){
                //project_type 1 == banner
                checkBannerVersions(response.data.feedback_id);
            }
            else if(response.data.project_type == 2){
                //project_type 2 == video
                getVideoData();
            }
            else if(response.data.project_type == 3){
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

    function checkBannerVersions(feedback_id){
        axios.get('/getVersionsFromFeedback/'+ feedback_id)
        .then(function (response){
            var isActive;

            if(response.data.versionCount > 1){
                var row = '';
                $.each(response.data.versions, function (key, value) {
                    if(value.id == response.data.isActiveVersion['id']){
                        isActive = ' versionTabActive';
                    }
                    else{
                        isActive = '';
                    }
                    row = row + '<div id="versionTab'+ value.id +'" class="versionTab'+ isActive +'" onclick="updateActiveVersion('+ value.id +')" style="margin-left: 2px; padding: 5px 25px 0 25px; border-top-left-radius: 17px; border-top-right-radius: 17px;">'+ value.name +'</div>';
                });
            }
            
            assignBannerFeedbackSettings(response.data.isActiveVersion['id']);
            getBannersData(response.data.isActiveVersion['id']);
            getFeedbackName(feedback_id);

            $('.versions').html(row);
        })
        .catch(function (error) {
            console.log(error);
        })
    }

    function updateActiveVersion(version_id){
        axios.get('/setActiveVersion/' + version_id)
        .then(function (response){
            checkBannerVersions(response.data.feedback_id);
        })
        .catch(function (error) {
            console.log(error);
        })
    }
    
    function getFeedbackName(feedback_id){
        axios.get('/getNewFeedbackName/'+ feedback_id)
        .then(function (response){
            $('#feedbackLabel').html(response.data);
        })
        .catch(function (error) {
            console.log(error);
        })
    }

    function assignBannerFeedbackSettings(version_id){
        rows = '';
            
        rows = rows + '<div>';
            rows = rows + '@if(Auth::check())';
                rows = rows + '@if(Auth::user()->company_id == 7) ';
                rows = rows + '@else';
                    rows = rows + '<div style="display: flex; color:{{ $info['color'] }}; font-size:25px;">';
                        rows = rows + '<a href="/project/preview/banner/add/version/'+ version_id +'" style="margin-right: 0.5rem;"><i class="fa-solid fa-plus"></i></a>';
                        rows = rows + '<a href="/project/preview/banner/edit/version/'+ version_id +'" style="margin-right: 0.5rem;"><i class="fa-solid fa-pen-to-square"></i></a>';
                    rows = rows + '</div>';
                rows = rows + '@endif';
            rows = rows + '@endif';
        rows = rows + '</div>';

        $('#feedbackSettings').html(rows);
    }

    function getBannersData(version_id){
        document.getElementById('loaderArea').style.display = 'block';
        axios.get('/getNewBannersData/'+ version_id)
        .then(function (response){
            console.log(response);
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
        Swal.fire({
            title: 'Are you sure you want to delete this banner?!',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Delete',
            denyButtonText: `Maybe I will think About It`,
        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                axios.get('/deleteBanner/'+ id)
                .then(function (response){
                    updateActiveVersion(response.data.version_id);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Banner Has Been Deleted!',
                        showConfirmButton: false,
                        timer: 1500
                    })
                })
                .catch(function (error){
                    console.log(error);
                })
            } else if (result.isDenied) {
                Swal.fire('Thanks for using your brain', '', 'info')
            }
        })
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