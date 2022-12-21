<main class="main">
    <?php $i=1; ?>
    <div class="container mx-auto px-4 py-3">
        <div id="tabs">
            @foreach ($data as $id => $row)
            <div id="version{{$id}}" class="versions @if(Helper::getFeedbackStatus($id) == 1) active @endif">
                {{ $i++ }}.{{ Helper::getFeedbackName($id) }}</div>
            @endforeach
        </div>
        <div id="bannershow" class="relative overflow-hidden">
            <div id="feedbackInfo">
                <label for="feedbackInfo" id="feedbackLabel">This is where the feedback info will appear</label>
            </div>
            <div id="bannerShowcase">
                this is where the banners will show
            </div>
            <br>
        </div>
    </div>
    <script>
        var header = document.getElementById("tabs");
        var btns = header.getElementsByClassName("versions");
        for (var i = 0; i < btns.length; i++) {
            btns[i].addEventListener("click", function () {
                let versionId = this.id;

                var current = document.getElementsByClassName("active");
                current[0].className = current[0].className.replace(" active", "");
                this.className += " active";

                getBanners(versionId);
            });
        }

        function getBanners(id){
            console.log('this is :' + id);

            axios.get('/getBannersForFeedback/'+ {{ $main_project_id }} + '/' + id)
            .then(function (response) {
                // handle success
                console.log(response);
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
        }

    </script>
</main>
