<main class="main">
    <?php $i=1; ?>
    <div class="container mx-auto px-4 py-3">
        <div id="tabs">
            @foreach ($data as $id => $row)
            <div id="version{{$id}}" class="versions @if($id == 2) active @endif">
                {{ $i++ }}.{{ Helper::getFeedbackName($id) }}</div>
            @endforeach
        </div>
        <div id="bannershow" class="py-2 relative">
            This is the div show part
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

                console.log(versionId);
            });
        }

    </script>
</main>
