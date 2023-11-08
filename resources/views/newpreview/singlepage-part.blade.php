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
        checkFeedbackType();
    });

    function checkFeedbackType(){
        axios.get('/getFeedbackType/'+ {{ $activeFeedback['id'] }})
        .then(function (response){
            setFeedbackName(response.data.feedback_name);

            if(response.data.project_type == 1){
                //project_type 1 == banner
                setBannerFeedbackVersions(response.data.versions);
                setBannerActiveVersionSettings(response.data.activeVersion_id);
                setBannerDisplayOfActiveVersion(response.data.activeVersion_id);
            }
            else if(response.data.project_type == 2){
                //project_type 2 == video
                setVideoFeedbackVersions(response.data.versions);
                setVideoActiveVersionSettings(response.data.activeVersion_id);
                setVideoDisplayOfActiveVersion(response.data.activeVersion_id);
            }
            else if(response.data.project_type == 3){
                //project_type 3 == gif
                setGifFeedbackVersions(response.data.versions);
                setGifActiveVersionSettings(response.data.activeVersion_id);
                setGifDisplayOfActiveVersion(response.data.activeVersion_id);
            }
            else{
                //project_type 4 or else == social
                setSocialFeedbackVersions(response.data.versions);
                setSocialActiveVersionSettings(response.data.activeVersion_id);
                setSocialDisplayOfActiveVersion(response.data.activeVersion_id);
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
        var feedbackLabel = gsap.timeline();
        feedbackLabel
        .to('#feedbackInfo', {duration: 1, y: 0, ease: 'power2.out'}, '=+0.5');
        $('#feedbackLabel').html(feedback_name);
    }

    function setBannerActiveVersionSettings(activeVersion_id){
        axios.get('/checkVersionCount/'+ activeVersion_id)
        .then(function (response){
            if(response.data == 1){
                var display = 'display: none;';
            }
            else{
                var display = 'display: block;';
            }

            rows = '';
            
            rows = rows + '<div>';
                rows = rows + '@if(Auth::check())';
                    rows = rows + '@if(Auth::user()->company_id == 10) ';
                    rows = rows + '@else';
                        rows = rows + '<div style="display: flex; color: #4b4e6d; font-size:25px;">';
                            rows = rows + '<a href="/project/preview/banner/add/version/'+ activeVersion_id +'" style="margin-right: 0.5rem;"><i class="fa-solid fa-folder-plus"></i></a>';
                            rows = rows + '<a href="/project/preview/banner/edit/version/'+ activeVersion_id +'" style="margin-right: 0.5rem;"><i class="fa-solid fa-square-pen"></i></a>';
                            rows = rows + '<a href="javascript:void(0)" onclick="return confirmBannerVersionDelete('+ activeVersion_id +')" style="'+ display +' margin-right: 0.5rem;"><i class="fa-solid fa-square-minus"></i></a>';
                        rows = rows + '</div>';
                    rows = rows + '@endif';
                rows = rows + '@endif';
            rows = rows + '</div>';
    
            $('#feedbackSettings').html(rows);
        })
        .catch(function (error){
            console.log(error);
        })
    }

    function setBannerDisplayOfActiveVersion(activeVersion_id){
        document.getElementById('loaderArea').style.display = 'flex';
        axios.get('/getActiveVersionBannerData/'+ activeVersion_id)
        .then(function (response){
            console.log(response);
            var row = '';

            $.each(response.data, function (key, value) {
                var resolution = value.size_id;
                var bannerPath = '/new_banners/' + value.file_path + '/index.html';
                var bannerReloadID = value.id;
                
                row = row + '<div style="display: inline-block; width: '+ value.width +'px; margin-right: 5px;">';
                    row = row + '<div style="display: flex; justify-content: space-between; background-color: #427D9D; padding: 5px; color: white; border-top-left-radius: 5px; border-top-right-radius: 5px;">';
                        row = row + '<small style="float: left;" id="bannerRes">'+ value.width + 'x' + value.height +'</small>';
                        row = row + '<small class="float: right; id="bannerSize">'+ value.size +'</small>';
                    row = row + '</div>';
                    row = row + '<iframe style="margin-top: 2px;" src="'+ bannerPath +'" width="'+ value.width +'" height="'+ value.height +'" frameBorder="0" scrolling="no" id='+ "rel" + value.id +'></iframe>';
                    row = row + '<ul style="display: flex; color: #4b4e6d; flex-direction: row;">';
                        row = row + '<li><i id="relBt'+ value.id +'" onClick="reload('+ bannerReloadID +')" class="fa-solid fa-arrows-rotate" style="display: flex; margin-top: 0.5rem; cursor: pointer; font-size:20px;"></i></li>';
                            row = row + '@if(Auth::check()) @if(Auth::user()->company_id == 10) @else'
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
            denyButtonText: `Thinking....`,
        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                axios.get('/deleteBannerVersion/'+ version_id)
                .then(function (response){
                    checkFeedbackType();
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

    function setVideoFeedbackVersions(versions){
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
                row = row + '<div id="versionTab'+ value.id +'" class="versionTab'+ isActive +'" onclick="updateVideoActiveVersion('+ value.id +')" style="margin-left: 2px; margin-right: 2px; padding: 5px 25px 0 25px; border-top-left-radius: 17px; border-top-right-radius: 17px;">'+ value.name +'</div>';
            });
        }
        else{
            var row = '';
        }
        $('.versions').html(row);
    }

    function setVideoActiveVersionSettings(activeVersion_id){
        axios.get('/checkVersionCount/'+ activeVersion_id)
        .then(function (response){
            if(response.data == 1){
                var display = 'display: none;';
            }
            else{
                var display = 'display: block;';
            }

            rows = '';
            
            rows = rows + '<div>';
                rows = rows + '@if(Auth::check())';
                    rows = rows + '@if(Auth::user()->company_id == 10) ';
                    rows = rows + '@else';
                        rows = rows + '<div style="display: flex; color: #4b4e6d; font-size:25px;">';
                            rows = rows + '<a href="/project/preview/video/add/version/'+ activeVersion_id +'" style="margin-right: 0.5rem;"><i class="fa-solid fa-folder-plus"></i></a>';
                            rows = rows + '<a href="/project/preview/video/edit/version/'+ activeVersion_id +'" style="margin-right: 0.5rem;"><i class="fa-solid fa-square-pen"></i></a>';
                            rows = rows + '<a href="javascript:void(0)" onclick="return confirmVideoVersionDelete('+ activeVersion_id +')" style="'+ display +' margin-right: 0.5rem;"><i class="fa-solid fa-square-minus"></i></a>';
                        rows = rows + '</div>';
                    rows = rows + '@endif';
                rows = rows + '@endif';
            rows = rows + '</div>';
    
            $('#feedbackSettings').html(rows);
        })
        .catch(function (error){
            console.log(error);
        })
    }

    function setVideoDisplayOfActiveVersion(activeVersion_id){
        document.getElementById('loaderArea').style.display = 'flex';
        axios.get('/getActiveVersionVideoData/'+ activeVersion_id)
        .then(function (response){
            console.log(response);
            var row = '';

            $.each(response.data, function (key, value) {
                var videoPath = '/new_videos/' + value.video_path;
                var posterPath = '/new_posters/' + value.poster_path;
                if((value.width == 1920 && value.height == 1080) || (value.width == 3840 && value.height == 2160)){
                    var class1 = '';
                    var class2 = '';
                    var innerClass = 'aspect-ratio-16-9';
                    var styleAspectRatio = '';
                    var innerWidth = 560;
                    var innerheight = 315;
                }
                else if(value.width == 1080 && value.height == 1080){
                    var class1 = 'md:flex';
                    var class2 = 'md:w-2/4';
                    var innerClass = 'aspect-ratio-1-1';
                    var styleAspectRatio = '';
                    var innerWidth = 560;
                    var innerheight = 'auto';
                }
                else if((value.width == 1080 && value.height == 1920) || (value.width == 2160 || value.height == 3840) || (value.width == 720 && value.height == 1280)){
                    var class1 = 'md:flex';
                    var class2 = 'md:w-2/4';
                    var innerClass = 'aspect-ratio-056-1';
                    var styleAspectRatio = 'aspect-ratio: 1/0.56';
                    var innerWidth = 560;
                    var innerheight = 'auto';
                }
                else if (value.width == 1080 && value.height == 1350){
                    var class1 = 'md:flex';
                    var class2 = 'md:w-2/4';
                    var innerClass = 'aspect-ratio-08-1';
                    var styleAspectRatio = 'aspect-ratio: 1/0.8';
                    var innerWidth = 560;
                    var innerheight = 'auto';
                }
                else if(value.width == 328 && value.height == 574){
                    var class1 = 'md:flex';
                    var class2 = 'md:w-2/4';
                    var innerClass = 'aspect-ratio-057-1';
                    var styleAspectRatio = 'aspect-ratio: 1/0.57';
                    var innerWidth = 560;
                    var innerheight = 'auto';
                }
                else if(value.width == 336 && value.height == 280){
                    var class1 = 'md:flex';
                    var class2 = '';
                    var innerClass = '';
                    var styleAspectRatio = 'aspect-ratio: 1.2/1; width: 336px; height: 280px;';
                    var innerWidth = '';
                    var innerheight = '';
                }
                else if(value.width == 1080 && value.height == 1536){
                    var class1 = 'md:flex';
                    var class2 = 'md:w-2/4';
                    var innerClass = 'aspect-ratio-07-1';
                    var styleAspectRatio = 'aspect-ratio: 1/0.7';
                    var innerWidth = 560;
                    var innerheight = 'auto';
                }
                else if(value.width == 1440 && value.height == 1080){
                    var class1 = 'md:flex';
                    var class2 = 'md:w-2/4';
                    var innerClass = 'aspect-ratio-043_1';
                    var styleAspectRatio = 'aspect-ratio: 1/0.43';
                    var innerWidth = 560;
                    var innerheight = 'auto';
                }
                else if(value.width == 1080 && value.height == 2536){
                    var class1 = '';
                    var class2 = '';
                    var innerClass = 'aspect-ratio-4-3';
                    var styleAspectRatio = '';
                    var innerWidth = 560;
                    var innerheight = 315;
                }
                else{
                    var class1 = '';
                    var class2 = '';
                    var innerClass = '';
                    var styleAspectRatio = '';
                    var innerWidth = 560;
                    var innerheight = 'auto';
                }
                row = row + '<div class="px-4">';
                    row = row + '<div class="md:flex -mx-8 mb-10">';
                        row = row + '<div class="md:w-3/4 mx-8">';
                            row = row + '<div class="videos">';
                                row = row + '<div class="'+ class1 +'">';
                                    row = row + '<div class="'+ class2 +'">';
                                        row = row + '<h2 class="text-xl font-semibold mb-4 px-2 py-2 video-title" style="background-color: {{$project_color}}; color: white; border-radius: 5px;">'+ value.title + '</h2>';
                                        row = row + '<div class="video-container '+  innerClass +'" style="'+ styleAspectRatio +'">';
                                            row = row + '<video class="video" muted playsinline controls controlsList="nodownload" data-poster="poster.jpg" width="'+ innerWidth +'" height="'+ innerHeight +'" style="border-radius: 8px; border: 1px solid #dedede;">';
                                                row = row + '<source src="'+ videoPath +'" type="video/mp4"/>';
                                            row = row + '</video>';
                                        row = row + '</div>';
                                    row = row + '</div>';
                                row = row + '</div>';
                            row = row + '</div>';
                            row = row + '<ul class="flex space-x-4 icons" style="color: #4b4e6d;">';
                                row = row + '@if(Auth::user())';
                                    row = row + '<li><a href="/project/preview/video/edit/'+ value.id +'" class="color-primary underline flex mt-4">Edit<svg class="w-6 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg></a></li>';
                                    row = row + '<li><a href="javascript:void(0)" onclick="return confirmDeleteVideo('+ value.id +')" class="color-primary underline flex mt-4">Delete<svg class="w-6 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></a></li>';
                                row = row + '@endif';
                                    row = row + '<li><a href="'+ videoPath +'" class="color-primary underline flex mt-4" download>Download<svg class="w-6 h-6 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg></a></li>';
                            row = row + '</ul>';
                        row = row + '</div>';

                        row = row + '<div class="md:w-1/4 mx-8" style="margin-top: 5rem;">';
                            row = row + '<h2 class="text-xl font-semibold" style="text-decoration: underline;">Specifications:</h2>';
                            row = row + '<table class="table w-full mt-2">';
                                row = row + '<tbody>';
                                    row = row + '<tr>';
                                        row = row + '<td style="text-align: left;">Aspect Ratio:</td>';
                                        row = row + '<td style="text-align: right;">'+ value.aspect_ratio +'</td>';
                                    row = row + '</tr>';
                                    row = row + '<tr>';
                                        row = row + '<td style="text-align: left;">Resolution (WxH):</td>';
                                        row = row + '<td style="text-align: right;">'+ value.width + 'x' + value.height +'</td>';
                                    row = row + '</tr>';
                                    row = row + '<tr>';
                                        row = row + '<td style="text-align: left;">Codec:</td>';
                                        row = row + '<td style="text-align: right;">'+ value.codec +'</td>';
                                    row = row + '</tr>';
                                    row = row + '<tr>';
                                        row = row + '<td style="text-align: left;">Framerate:</td>';
                                        row = row + '<td style="text-align: right;">'+ value.fps +'</td>';
                                    row = row + '</tr>';
                                    row = row + '<tr>';
                                        row = row + '<td style="text-align: left;">Size:</td>';
                                        row = row + '<td style="text-align: right;">'+ value.size +'</td>';
                                    row = row + '</tr>';
                                row = row + '</tbody>';
                            row = row + '</table>';

                        if(value.poster_path){
                            row = row + '<div class="mt-4">';
                                row = row + '<div class="companion-banner">';
                                    row = row + '<h2 class="text-xl font-semibold mb-4" style="text-decoration: underline;">Companion Banner</h2>';

                                    row = row + '<img class="block companion-img" src="'+ posterPath +'" alt="companion banner">';
                                    row = row + '<div class="flex items-center space-x-4 mt-2 justify-center">';
                                        row = row + '@if(Auth::user())';
                                        row = row + ' <a href="javascript:void(0)" onclick="return confirmDeleteVideoPoster('+ value.id +')"  class="color-primary underline flex" style="text-align: center;">Delete';
                                            row = row + '<svg class="w-6 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>'
                                        row = row + '</a>';
                                        row = row + '@endif';
                                        row = row + ' <a href="'+ posterPath +'" class="color-primary underline flex" download style="text-align: center;">Download Banner';
                                            row = row + '<svg class="w-6 h-6 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>'
                                        row = row + '</a>';
                                    row = row + '</div>';
                                row = row + '</div>';
                            row = row + '</div>';
                        }
                        row = row + '</div>';
                    row = row + '</div>';
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

    function confirmDeleteVideo(id) {
        Swal.fire({
            title: 'Are you sure you want to delete this video?!',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Delete',
            denyButtonText: `Thinking....`,
        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                axios.get('/deleteVideo/'+ id)
                .then(function (response){
                    setVideoDisplayOfActiveVersion(response.data.version_id);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Video Has Been Deleted!',
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

    function confirmDeleteVideoPoster(id){
        Swal.fire({
            title: 'Are you sure you want to delete this poster?!',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Delete',
            denyButtonText: `Thinking....`,
        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                axios.get('/deleteVideoPoster/'+ id)
                .then(function (response){
                    setVideoDisplayOfActiveVersion(response.data.version_id);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Poster Has Been Deleted!',
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

    function updateVideoActiveVersion(version_id){
        axios.get('/setVideoActiveVersion/' + version_id)
        .then(function (response){
            setVideoFeedbackVersions(response.data.versions);
            setVideoActiveVersionSettings(response.data.activeVersion_id);
            setVideoDisplayOfActiveVersion(response.data.activeVersion_id);
        })
        .catch(function (error) {
            console.log(error);
        })
    }

    function confirmVideoVersionDelete(version_id){
        Swal.fire({
            title: 'Are you sure you want to delete this version?!',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Delete',
            denyButtonText: `Thinking....`,
        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                axios.get('/deleteVideoVersion/'+ version_id)
                .then(function (response){
                    checkFeedbackType();
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

    function setGifFeedbackVersions(versions){
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
                row = row + '<div id="versionTab'+ value.id +'" class="versionTab'+ isActive +'" onclick="updateGifActiveVersion('+ value.id +')" style="margin-left: 2px; margin-right: 2px; padding: 5px 25px 0 25px; border-top-left-radius: 17px; border-top-right-radius: 17px;">'+ value.name +'</div>';
            });
        }
        else{
            var row = '';
        }
        $('.versions').html(row);
    }

    function setGifActiveVersionSettings(activeVersion_id){
        axios.get('/checkVersionCount/'+ activeVersion_id)
        .then(function (response){
            if(response.data == 1){
                var display = 'display: none;';
            }
            else{
                var display = 'display: block;';
            }

            rows = '';
            
            rows = rows + '<div>';
                rows = rows + '@if(Auth::check())';
                    rows = rows + '@if(Auth::user()->company_id == 10) ';
                    rows = rows + '@else';
                        rows = rows + '<div style="display: flex; color: #4b4e6d; font-size:25px;">';
                            rows = rows + '<a href="/project/preview/gif/add/version/'+ activeVersion_id +'" style="margin-right: 0.5rem;"><i class="fa-solid fa-folder-plus"></i></a>';
                            rows = rows + '<a href="/project/preview/gif/edit/version/'+ activeVersion_id +'" style="margin-right: 0.5rem;"><i class="fa-solid fa-square-pen"></i></a>';
                            rows = rows + '<a href="javascript:void(0)" onclick="return confirmGifVersionDelete('+ activeVersion_id +')" style="'+ display +' margin-right: 0.5rem;"><i class="fa-solid fa-square-minus"></i></a>';
                        rows = rows + '</div>';
                    rows = rows + '@endif';
                rows = rows + '@endif';
            rows = rows + '</div>';
    
            $('#feedbackSettings').html(rows);
        })
        .catch(function (error){
            console.log(error);
        })
    }

    function setGifDisplayOfActiveVersion(activeVersion_id){
        document.getElementById('loaderArea').style.display = 'flex';
        axios.get('/getActiveVersionGifData/'+ activeVersion_id)
        .then(function (response){
            console.log(response);
            var row = '';

            $.each(response.data, function (key, value) {
                var resolution = value.size_id;
                var bannerPath = '/new_gifs/' + value.file_path;
                var bannerReloadID = value.id;
                
                row = row + '<div style="display: inline-block; width: '+ value.width +'px; margin-right: 5px;">';
                    row = row + '<div style="display: flex; justify-content: space-between; background-color: #427D9D; padding: 5px; color: white; border-top-left-radius: 5px; border-top-right-radius: 5px;">';
                        row = row + '<small style="float: left;" id="bannerRes">'+ value.width + 'x' + value.height +'</small>';
                        row = row + '<small class="float: right; id="bannerSize">'+ value.size +'</small>';
                    row = row + '</div>';
                    row = row + '<iframe style="margin-top: 2px; border: 1px solid #dedede;" src="'+ bannerPath +'" width="'+ value.width +'" height="'+ value.height +'" frameBorder="0" scrolling="no" id='+ "rel" + value.id +'></iframe>'
                    row = row + '<ul style="display: flex; color: #4b4e6d; flex-direction: row;">';
                        row = row + '<li><i id="relBt'+ value.id +'" onClick="reload('+ bannerReloadID +')" class="fa-solid fa-arrows-rotate" style="display: flex; margin-top: 0.5rem; cursor: pointer; font-size:20px;"></i></li>';
                            row = row + '@if(Auth::check()) @if(Auth::user()->company_id == 10) @else'
                                row = row + '<li><a href="/project/preview/gif/edit/'+ value.id +'"><i class="fa-solid fa-gear" style="display: flex; margin-top: 0.5rem; margin-left: 0.5rem; font-size:20px;"></i></a></li>';
                                row = row + '<li><a href="'+ bannerPath +'" download><i class="fa-solid fa-circle-down" style="display: flex; margin-top: 0.5rem; margin-left: 0.5rem; font-size:20px;"></i></a></li>';
                                row = row + '<li><a href="javascript:void(0)" onclick="return confirmDeleteGif('+ value.id +')"><i class="fa-solid fa-trash-can" style="display: flex; margin-top: 0.5rem; margin-left: 0.5rem; font-size:20px;"></i></a></li>';
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

    function updateGifActiveVersion(version_id){
        axios.get('/setGifActiveVersion/' + version_id)
        .then(function (response){
            setGifFeedbackVersions(response.data.versions);
            setGifActiveVersionSettings(response.data.activeVersion_id);
            setGifDisplayOfActiveVersion(response.data.activeVersion_id);
        })
        .catch(function (error) {
            console.log(error);
        })
    }

    function confirmGifVersionDelete(version_id){
        Swal.fire({
            title: 'Are you sure you want to delete this version?!',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Delete',
            denyButtonText: `Thinking....`,
        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                axios.get('/deleteGifVersion/'+ version_id)
                .then(function (response){
                    checkFeedbackType();
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

    function confirmDeleteGif(id) {
        Swal.fire({
            title: 'Are you sure you want to delete this gif?!',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Delete',
            denyButtonText: `Thinking....`,
        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                axios.get('/deleteGif/'+ id)
                .then(function (response){
                    setGifDisplayOfActiveVersion(response.data.version_id);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Gif Has Been Deleted!',
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

    function setSocialFeedbackVersions(versions){
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
                row = row + '<div id="versionTab'+ value.id +'" class="versionTab'+ isActive +'" onclick="updateSocialActiveVersion('+ value.id +')" style="margin-left: 2px; margin-right: 2px; padding: 5px 25px 0 25px; border-top-left-radius: 17px; border-top-right-radius: 17px;">'+ value.name +'</div>';
            });
        }
        else{
            var row = '';
        }
        $('.versions').html(row);
    }

    function setSocialActiveVersionSettings(activeVersion_id){
        axios.get('/checkVersionCount/'+ activeVersion_id)
        .then(function (response){
            if(response.data == 1){
                var display = 'display: none;';
            }
            else{
                var display = 'display: block;';
            }

            rows = '';
            
            rows = rows + '<div>';
                rows = rows + '@if(Auth::check())';
                    rows = rows + '@if(Auth::user()->company_id == 10) ';
                    rows = rows + '@else';
                        rows = rows + '<div style="display: flex; color: #4b4e6d; font-size:25px;">';
                            rows = rows + '<a href="/project/preview/social/add/version/'+ activeVersion_id +'" style="margin-right: 0.5rem;"><i class="fa-solid fa-folder-plus"></i></a>';
                            rows = rows + '<a href="/project/preview/social/edit/version/'+ activeVersion_id +'" style="margin-right: 0.5rem;"><i class="fa-solid fa-square-pen"></i></a>';
                            rows = rows + '<a href="javascript:void(0)" onclick="return confirmSocialVersionDelete('+ activeVersion_id +')" style="'+ display +' margin-right: 0.5rem;"><i class="fa-solid fa-square-minus"></i></a>';
                        rows = rows + '</div>';
                    rows = rows + '@endif';
                rows = rows + '@endif';
            rows = rows + '</div>';
    
            $('#feedbackSettings').html(rows);
        })
        .catch(function (error){
            console.log(error);
        })
    }

    function setSocialDisplayOfActiveVersion(activeVersion_id){
        document.getElementById('loaderArea').style.display = 'flex';
        axios.get('/getActiveVersionSocialData/'+ activeVersion_id)
        .then(function (response){
            var row = '';

            row = row + '<div style="text-align:center; ">';
                row = row + '<strong>Click on the images below</strong>';
            row = row + '</div>';
            row = row + '<div class="rowSocial" style="margin-top: 15px;">';

            $.each(response.data, function (key, value) {
                var file_path = '/new_socials/'+ value.file_path;
                if(value.width >= 1000){
                    var displayWidth = value.width/2.75;
                }
                else{
                    var displayWidth = value.width;
                }

                row = row + '<div class="columnSocial" style="margin-top: 10px;">';
                    row = row + '<div style="display: flex; justify-content: space-between; background-color: #427D9D; padding: 5px; color: white; border-radius: 5px;">';
                        row = row + '<small style="float: left;">'+ value.width + 'x' + value.height +'</small>';
                        row = row + '<small class="float: right;">'+ value.size +'</small>';
                    row = row + '</div>';

                    row = row + '<img src="'+ file_path +'" alt="'+ value.name +'" onclick="myFunction(this, '+ value.width +', '+ value.height +');" class="imagesSocial" style="margin-top: 2px; width: '+ displayWidth +'px; height: auto;">';

                    row = row + '<ul style="display: flex; color: #4b4e6d; flex-direction: row;">';
                        row = row + '@if(Auth::check()) @if(Auth::user()->company_id == 10) @else'
                            row = row + '<li><a href="/project/preview/social/edit/'+ value.id +'"><i class="fa-solid fa-gear" style="display: flex; margin-top: 0.5rem; margin-left: 0.5rem; font-size:20px;"></i></a></li>';
                            row = row + '<li><a href="'+ file_path +'" download><i class="fa-solid fa-circle-down" style="display: flex; margin-top: 0.5rem; margin-left: 0.5rem; font-size:20px;"></i></a></li>';
                            row = row + '<li><a href="javascript:void(0)" onclick="return confirmDeleteSocial('+ value.id +')"><i class="fa-solid fa-trash-can" style="display: flex; margin-top: 0.5rem; margin-left: 0.5rem; font-size:20px;"></i></a></li>';
                        row = row + '@endif';
                        row = row + '@endif';
                    row = row + '</ul>';
                row = row + '</div>';
            });

                row = row + '<div id="myModal" class="modalSocial">';
                    row = row + '<span class="closeSocial">&times;</span>';
                    row = row + '<img class="modal-contentSocial" id="img01">';
                    row = row + '<div id="captionSocial"></div>';
                row = row + '</div>';

            row = row + '</div>';

            $('#bannerShowcase').html(row);
        })
        .catch(function (error){
            console.log(error);
        })
        .finally(function(){
            document.getElementById('loaderArea').style.display = 'none';
        })
    }

    $(".imagesSocial").wrap('<div class="alt-wrapSocial"/>');
    $(".imagesSocial").each(function () {
        $(this).after('<p class="alt">' + $(this).attr('alt') + '</p>');
    });

    function myFunction(imgs, imageWidth, imageHeight) {
        console.log(imageWidth + ' ' + imageHeight);

        var modal = document.getElementById("myModal");
        var modalImg = document.getElementById("img01");
        var captionText = document.getElementById("captionSocial");
        var anotherCaptionText = document.getElementById("anotherCaptionSocial");
        modal.style.display = "block";
        modalImg.src = imgs.src;

        if(imageWidth >= 2200){
            modalImg.style.width = null;
            modalImg.style.height = null;
            modalImg.style.maxWidth = "1200px";
        }
        else if(imageWidth >= 1000){
            modalImg.style.width = null;
            modalImg.style.height = null;
            modalImg.style.maxWidth = "700px";
        }
        else{
            modalImg.style.width = imageWidth + 'px';
            modalImg.style.height = imageHeight + 'px';
            modalImg.style.maxWidth = "700px";
        }

        captionText.innerHTML = imgs.alt;

        var span = document.getElementsByClassName("closeSocial")[0];
        var modal = document.getElementsByClassName("modalSocial")[0];
        var except = document.getElementById('img01');

        span.onclick = function () {
            modal.style.display = "none";
        }

        modal.onclick = function (e) {
            if ( !except.contains(e.target) ) { //if the clicked element is the feedback div then it wont disappear
                modal.style.display = "none";
            }
        }
    }

    function updateSocialActiveVersion(version_id){
        axios.get('/setSocialActiveVersion/' + version_id)
        .then(function (response){
            setSocialFeedbackVersions(response.data.versions);
            setSocialActiveVersionSettings(response.data.activeVersion_id);
            setSocialDisplayOfActiveVersion(response.data.activeVersion_id);
        })
        .catch(function (error) {
            console.log(error);
        })
    }

    function confirmSocialVersionDelete(version_id){
        Swal.fire({
            title: 'Are you sure you want to delete this version?!',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Delete',
            denyButtonText: `Thinking....`,
        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                axios.get('/deleteSocialVersion/'+ version_id)
                .then(function (response){
                    checkFeedbackType();
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

    function confirmDeleteSocial(id){
        Swal.fire({
            title: 'Are you sure you want to delete this social?!',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Delete',
            denyButtonText: `Thinking....`,
        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                axios.get('/deleteSocial/'+ id)
                .then(function (response){
                    setSocialDisplayOfActiveVersion(response.data.version_id);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Social Has Been Deleted!',
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
    
</script>