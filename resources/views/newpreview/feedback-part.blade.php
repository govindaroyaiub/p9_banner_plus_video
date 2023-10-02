
<nav role="navigation">
    <div id="menuToggle">
        <input type="checkbox" />
        <span></span>
        <span></span>
        <span></span>
        <ul id="menu">
            @foreach ($feedbacks as $feedback)
                <a href="#" class="feedbacks" id="feedback{{$feedback->id}}"><li @if($feedback['is_active'] == 1) class="menuToggleActive" @endif>{{ $feedback->name }}</li></a>
            @endforeach
        </ul>
    </div>
</nav>
<div id="bannershow" class="relative" style="top: -27px;">
    <div id="feedbackInfo"><label for="feedbackInfo" id="feedbackLabel"></label></div>
    <div style="display: flex; flex-direction: row; flex-wrap: nowrap; justify-content: space-between; justify-content: center; padding: 10px;">
        <div id="feedbackSettings"></div>
    </div>
    <br>
    <div id="bannerShowcase"></div>
    <br>
</div>

<script>
    $(document).ready(function(){
        getActiveFeedbackProjectType();
    });

    function getActiveFeedbackProjectType(){
        document.getElementById('loaderArea').style.display = 'flex';
        axios.get('/getActiveFeedbackProjectType/'+ {{ $activeFeedback['id'] }})
        .then(function (response){
            if(response.data.project_type == 1){
                displayActiveVersionBanners(response.data.active_version);
                displayActiveVersionSettings(response.data.active_version);
                setBannerFeedbackVersions(response.data.versions);
                setBannerFeedbackName(response.data.feedback_name);
            }
        })
        .catch(function (error) {
            console.log(error);
        })
        .finally(function(){
            document.getElementById('loaderArea').style.display = 'none';
        })
    }

    function setBannerFeedbackVersions(versions){
        var isActive;

        if(versions.length > 1){
            var row = '';
            $.each(versions, function (key, value) {
                if(value.id == response.data.isActiveVersion['id']){
                    isActive = ' versionTabActive';
                }
                else{
                    isActive = '';
                }
                row = row + '<div id="versionTab'+ value.id +'" class="versionTab'+ isActive +'" onclick="updateActiveVersion('+ value.id +')" style="margin-left: 2px; margin-right: 2px; padding: 5px 25px 0 25px; border-top-left-radius: 17px; border-top-right-radius: 17px;">'+ value.name +'</div>';
            });
        }
        else{
            var row = '';
        }
        $('.versions').html(row);
    }

    function displayActiveVersionSettings(version){
        rows = '';
            
        rows = rows + '<div>';
            rows = rows + '@if(Auth::check())';
                rows = rows + '@if(Auth::user()->company_id == 7) ';
                rows = rows + '@else';
                    rows = rows + '<div style="display: flex; color:{{ $info['color'] }}; font-size:25px;">';
                        rows = rows + '<a href="/project/preview/banner/add/version/'+ version +'" style="margin-right: 0.5rem;"><i class="fa-solid fa-folder-plus"></i></a>';
                        rows = rows + '<a href="/project/preview/banner/edit/version/'+ version +'" style="margin-right: 0.5rem;"><i class="fa-solid fa-square-pen"></i></a>';
                        rows = rows + '<a href="javascript:void(0)" onclick="return confirmBannerVersionDelete('+ version +')" style="margin-right: 0.5rem;"><i class="fa-solid fa-square-minus"></i></a>';
                    rows = rows + '</div>';
                rows = rows + '@endif';
            rows = rows + '@endif';
        rows = rows + '</div>';

        $('#feedbackSettings').html(rows);
    }

    function displayActiveVersionBanners(active_version){
        axios.get('/getNewBannersData/'+ active_version)
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
                        row = row + '<li><i id="relBt'+ value.id +'" onClick="reload('+ bannerReloadID +')" class="fa-solid fa-arrows-rotate" style="display: flex; margin-top: 0.5rem; cursor: pointer; font-size:20px;"></i></li>';
                            row = row + '@if(Auth::check()) @if(Auth::user()->company_id == 7) @else'
                                row = row + '<li><a href="/project/preview/banner/edit/'+ value.id +'"><i class="fa-solid fa-gear" style="display: flex; margin-top: 0.5rem; margin-left: 0.5rem; font-size:20px;"></i></a></li>';
                                row = row + '<li><a href="/project/preview/banner/download/'+ value.id +'"><i class="fa-solid fa-circle-down" style="display: flex; margin-top: 0.5rem; margin-left: 0.5rem; font-size:20px;"></i></a></li>';
                                row = row + '<li><a href="javascript:void(0)" onclick="return confirmDeleteBanner('+ value.id +',' + active_version + ')"><i class="fa-solid fa-trash-can" style="display: flex; margin-top: 0.5rem; margin-left: 0.5rem; font-size:20px;"></i></a></li>';
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

    }

    function setBannerFeedbackName(feedbackName){
        $('#feedbackLabel').html(feedbackName);
    }

    function confirmDeleteBanner(id, activeVersion) {
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
                    displayActiveVersionBanners(activeVersion);
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

    function confirmBannerVersionDelete(version_id){
        Swal.fire({
            title: 'Are you sure you want to delete this version?!',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Delete',
            denyButtonText: `Maybe I will think About It`,
        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                axios.get('/deleteBannerVersion/'+ version_id)
                .then(function (response){
                    checkBannerVersions(response.data.feedback_id);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Version Has Been Deleted!',
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
</script>