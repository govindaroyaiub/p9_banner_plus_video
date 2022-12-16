<main class="main">
    <?php $i=1; ?>
    <div class="container mx-auto px-4 py-3">
        <div class="tabs">

            @foreach ($data as $id => $row)
            <input type="radio" name="tabs" id="version{{$id}}" checked="checked" class="versions">
            <label for="version{{$id}}">{{$i++}}. {{ Helper::getFeedbackName($id) }}</label>
            <div class="tab">
                <div style="border-color: {{ $project_color }}"></div>
            </div>
            @endforeach
        </div>
    </div>
    <script>
        var versions = document.getElementsByClassName('versions')

        for (var i = 0; i < versions.length; ++i) {
            versions[i].addEventListener('click', getVersionData);
        }

        function getVersionData() {
            var versionElement = this.id;

            
        }

    </script>
</main>
