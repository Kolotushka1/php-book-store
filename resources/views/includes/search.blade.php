<form action="{{ route('showCatalogWithFilters') }}" method="GET">
        <div id="searchInputBlock" class="input-group">
            <input name="title" id="searchInput" type="text" class="form-control rounded-2 shadow-none border-0" placeholder="Что будем искать?">
            <div class="input-group-append">
                <button type="submit" class="btn rounded-2" style="background-color: #20A3DC; border: none; margin-right: 30px; margin-top: 10px; margin-bottom: 10px;">
                    <img src="{{asset('images/styles/searchVector.svg')}}" alt="Search">
                </button>
            </div>
        </div>
</form>
