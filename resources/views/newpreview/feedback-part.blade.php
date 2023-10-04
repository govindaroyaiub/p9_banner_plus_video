<div id="bannershow" class="relative" style="top: -27px;">
    <nav role="navigation">
        <div id="menuToggle">
            <input type="checkbox" id="menuClick" />
            <span></span>
            <span></span>
            <span></span>
            <ul id="menu"></ul>
        </div>
    </nav>

    <div id="feedbackArea">
        <div id="feedbackCLick" onclick="showFeedbackMessage()">
            <i class="fa-regular fa-message"></i>
        </div>
        <div id="feedbackDescription">
            <div id="feedbackDescriptionUpperpart" onclick="hideFeedbackMessage()">
                <div class="cursor-pointer" style="float: right;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>  
                </div>
            </div>
            <div id="feedbackDescriptionLowerPart">
                <label id="feedbackMessage"></label> 
            </div>
        </div>
    </div>

    <div id="feedbackInfo"><label for="feedbackInfo" id="feedbackLabel"></label></div>
    <div style="position: relative; top: 15px; display: flex; flex-direction: row; flex-wrap: nowrap; justify-content: space-between; justify-content: center; padding: 10px;">
        <div id="versionSettings"></div>
        <div id="feedbackSettings" style="position: absolute; right: 2%;"></div>
    </div>
    <br>
    <div id="bannerShowcase"></div>
    <br>
</div>

<script>
    $(document).ready(function(){
        getAllFeedbacks();
    });

    function showFeedbackMessage(){
        var moveFeedback = gsap.timeline();

        moveFeedback
        .to('#feedbackDescription', {duration: 1, x: 0, ease: 'power2.out'})
    }

    function hideFeedbackMessage(){
        var moveFeedback = gsap.timeline();

        moveFeedback
        .to('#feedbackDescription', {duration: 0.5, x: 310, ease: 'power2.in'})
    }

    function getAllFeedbacks(){
        axios.get('/getAllFeedbacks/'+ {{ $main_project_id }})
        .then(function (response){
            var active;
            var row = '';

            $.each(response.data.feedbacks, function (key, value) {
                if(value.is_active == 1){
                    active = 'menuToggleActive';
                }
                else{
                    active = '';
                }
                row = row + '<a href="javascript:void(0)" class="feedbacks" onclick="return updateActiveFeedback('+ value.id +')" id="feedback'+value.id+'">'
                    row = row + '<li class="'+ active +'">'+ value.name +'</li>'
                row = row + '</a>';
            });

            $('#menu').html(row);

            checkFeedbackType(response.data.activeFeedback_id);
        })
        .catch(function (error) {
            console.log(error);
        })
    }

    function updateActiveFeedback(feedback_id){
        axios.get('/updateActiveFeedback/'+ feedback_id)
        .then(function (response){
            document.getElementById('menuClick').click();

            var active;
            var row = '';
            $.each(response.data.feedbacks, function (key, value) {
                if(value.is_active == 1){
                    active = 'menuToggleActive';
                }
                else{
                    active = '';
                }
                row = row + '<a href="javascript:void(0)" class="feedbacks" onclick="return updateActiveFeedback('+ value.id +')" id="feedback'+value.id+'">'
                    row = row + '<li class="'+ active +'">'+ value.name +'</li>'
                row = row + '</a>';
            });

            $('#menu').html(row);

            checkFeedbackType(response.data.activeFeedback_id);
        })
        .catch(function (error) {
            console.log(error);
        })
    }

    function checkFeedbackType(activeFeedback_id){
        axios.get('/getFeedbackType/'+ activeFeedback_id)
        .then(function (response){
            if(response.data.project_type == 1){
                //project_type 1 == banner
                setFeedbackName(response.data.feedback_name);
                setFeedbackDescription(response.data.feedback_description);
                setBannerFeedbackVersions(response.data.versions);
                setBannerActiveVersionSettings(response.data.activeVersion_id);
                setBannerActiveFeedbackSettings(activeFeedback_id);
                setBannerDisplayOfActiveVersion(response.data.activeVersion_id);
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

    function setBannerFeedbackVersions(versions){
        var versionCount = versions.length;
        var isActive;

        if(versionCount > 1){
            var row = '';
            $.each(versions, function (key, value) {
                if(value.is_active == 1){
                    isActive = ' versionTabActive';
                }
                else{
                    isActive = '';
                }
                row = row + '<div id="versionTab'+ value.id +'" class="versionTab'+ isActive +'" onclick="updateBannerActiveVersion('+ value.id +')" style="margin-left: 2px; margin-right: 2px; padding: 5px 25px 0 25px; border-top-left-radius: 17px; border-top-right-radius: 17px;">'+ value.name +'</div>';
            });
        }
        else{
            var row = '';
        }
        $('.versions').html(row);
    }

    function updateBannerActiveVersion(version_id){
        axios.get('/setBannerActiveVersion/' + version_id)
        .then(function (response){
            setBannerFeedbackVersions(response.data.versions);
            setBannerActiveVersionSettings(response.data.activeVersion_id);
            setBannerDisplayOfActiveVersion(response.data.activeVersion_id);
        })
        .catch(function (error) {
            console.log(error);
        })
    }
    
    function setFeedbackName(feedback_name){
        $('#feedbackLabel').html(feedback_name);
    }

    function setFeedbackDescription(feedback_description){
        $('#feedbackMessage').html(feedback_description);
    }

    function setBannerActiveVersionSettings(activeVersion_id){
        axios.get('/checkVersionCount/'+ activeVersion_id)
        .then(function (response){
            console.log(response);
            if(response.data == 1){
                var display = 'display: none;';
            }
            else{
                var display = 'display: block;';
            }

            rows = '';
            
            rows = rows + '<div>';
                rows = rows + '@if(Auth::check())';
                    rows = rows + '@if(Auth::user()->company_id == 7) ';
                    rows = rows + '@else';
                        rows = rows + '<div style="display: flex; color:{{ $info['color'] }}; font-size:25px;">';
                            rows = rows + '<a href="/project/preview/banner/add/version/'+ activeVersion_id +'" style="margin-right: 0.5rem;"><i class="fa-solid fa-folder-plus"></i></a>';
                            rows = rows + '<a href="/project/preview/banner/edit/version/'+ activeVersion_id +'" style="margin-right: 0.5rem;"><i class="fa-solid fa-square-pen"></i></a>';
                            rows = rows + '<a href="javascript:void(0)" onclick="return confirmBannerVersionDelete('+ activeVersion_id +')" style="'+ display +' margin-right: 0.5rem;"><i class="fa-solid fa-square-minus"></i></a>';
                        rows = rows + '</div>';
                    rows = rows + '@endif';
                rows = rows + '@endif';
            rows = rows + '</div>';
    
            $('#versionSettings').html(rows);
        })
        .catch(function (error){
            console.log(error);
        })
    }

    function setBannerActiveFeedbackSettings(activeFeedback_id){
        rows = '';
            
        rows = rows + '<div>';
            rows = rows + '@if(Auth::check())';
                rows = rows + '@if(Auth::user()->company_id == 7) ';
                rows = rows + '@else';
                    rows = rows + '<div style="display: flex; color:{{ $info['color'] }}; font-size:25px;">';
                        rows = rows + '<a href="/project/preview/edit/feedback/'+ activeFeedback_id +'" style="margin-right: 0.5rem;"><i class="fa-solid fa-pen-to-square"></i></a>';
                        rows = rows + '<a href="javascript:void(0)" onclick="return confirmFeedbackDelete('+ activeFeedback_id +')" style="margin-right: 0.5rem;"><i class="fa-solid fa-circle-minus"></i></a>';
                    rows = rows + '</div>';
                rows = rows + '@endif';
            rows = rows + '@endif';
        rows = rows + '</div>';

        $('#feedbackSettings').html(rows);
    }

    function setBannerDisplayOfActiveVersion(activeVersion_id){
        document.getElementById('loaderArea').style.display = 'flex';
        axios.get('/getActiveVwersionBannerData/'+ activeVersion_id)
        .then(function (response){
            var row = '';

            $.each(response.data, function (key, value) {
                var resolution = value.size_id;
                var bannerPath = '/new_showcase_collection/' + value.file_path + '/index.html';
                var bannerReloadID = value.id;
                
                row = row + '<div style="display: inline-block; width: '+ value.width +'px; margin-right: 5px;">';
                    row = row + '<div style="display: flex; justify-content: space-between; background-color: #F15A29; padding: 5px; color: white; border-top-left-radius: 5px; border-top-right-radius: 5px;">';
                        row = row + '<small style="float: left;" id="bannerRes">'+ value.width + 'x' + value.height +'</small>';
                        row = row + '<small class="float: right; id="bannerSize">'+ value.size +'</small>';
                    row = row + '</div>';
                    row = row + '<iframe style="margin-top: 2px;" src="'+ bannerPath +'" width="'+ value.width +'" height="'+ value.height +'" frameBorder="0" scrolling="no" id='+ "rel" + value.id +'></iframe>'
                    row = row + '<ul style="display: flex; color:{{ $info['color'] }}; flex-direction: row;">';
                        row = row + '<li><i id="relBt'+ value.id +'" onClick="reload('+ bannerReloadID +')" class="fa-solid fa-arrows-rotate" style="display: flex; margin-top: 0.5rem; cursor: pointer; font-size:20px;"></i></li>';
                            row = row + '@if(Auth::check()) @if(Auth::user()->company_id == 7) @else'
                                row = row + '<li><a href="/project/preview/banner/edit/'+ value.id +'"><i class="fa-solid fa-gear" style="display: flex; margin-top: 0.5rem; margin-left: 0.5rem; font-size:20px;"></i></a></li>';
                                row = row + '<li><a href="/project/preview/banner/download/'+ value.id +'"><i class="fa-solid fa-circle-down" style="display: flex; margin-top: 0.5rem; margin-left: 0.5rem; font-size:20px;"></i></a></li>';
                                row = row + '<li><a href="javascript:void(0)" onclick="return confirmDeleteBanner('+ value.id +')"><i class="fa-solid fa-trash-can" style="display: flex; margin-top: 0.5rem; margin-left: 0.5rem; font-size:20px;"></i></a></li>';
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

    function confirmFeedbackDelete(feedback_id){
        Swal.fire({
            title: 'Are you sure you want to delete this feedback?!',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Delete',
            denyButtonText: `Thinking....`,
        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                axios.get('/deleteFeedback/'+ feedback_id)
                .then(function (response){
                    location.reload();
                })
                .catch(function (error){
                    console.log(error);
                })
            } else if (result.isDenied) {
                Swal.fire('Thanks for using your brain', '', 'info')
            }
        })
    }

    function confirmDeleteBanner(id) {
        Swal.fire({
            title: 'Are you sure you want to delete this banner?!',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Delete',
            denyButtonText: `Thinking....`,
        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                axios.get('/deleteBanner/'+ id)
                .then(function (response){
                    setBannerDisplayOfActiveVersion(response.data.version_id);
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
            denyButtonText: `Thinking.....`,
        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                axios.get('/deleteBannerVersion/'+ version_id)
                .then(function (response){
                    checkFeedbackType(response.data.feedback_id);
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