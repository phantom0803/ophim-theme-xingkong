<div>
    <h2 class="title">Bộ lọc phim</h2>
    <form action="/" method="GET" id="form-filter">
        <div class="row">
            <div class="form-group col-md-6 col-sm-3 col-xs-2">
                <select class="form-control" id="sort" name="filter[sort]" form="form-filter">
                    <option value="">Sắp xếp</option>
                    <option value="update" @if (isset(request('filter')['sort']) && request('filter')['sort'] == 'update') selected @endif>Thời gian cập nhật
                    </option>
                    <option value="create" @if (isset(request('filter')['sort']) && request('filter')['sort'] == 'create') selected @endif>Thời gian đăng</option>
                    <option value="year" @if (isset(request('filter')['sort']) && request('filter')['sort'] == 'year') selected @endif>Năm sản xuất</option>
                    <option value="view" @if (isset(request('filter')['sort']) && request('filter')['sort'] == 'view') selected @endif>Lượt xem</option>
                </select>
            </div>
            <div class="form-group col-md-6 col-sm-3 col-xs-2">
                <select class="form-control" id="type" name="filter[type]" form="form-filter">
                    <option value="">Mọi định dạng</option>
                    <option value="series" @if (isset(request('filter')['type']) && request('filter')['type'] == 'series') selected @endif>Phim bộ</option>
                    <option value="single" @if (isset(request('filter')['type']) && request('filter')['type'] == 'single') selected @endif>Phim lẻ</option>
                </select>
            </div>
            <div class="form-group col-md-6 col-sm-3 col-xs-2">
                <select class="form-control" id="category" name="filter[category]" form="form-filter">
                    <option value="">Tất cả thể loại</option>
                    @foreach (\Ophim\Core\Models\Category::fromCache()->all() as $item)
                        <option value="{{ $item->id }}" @if (
                            (isset(request('filter')['category']) && request('filter')['category'] == $item->id) ||
                                (isset($category) && $category->id == $item->id)) selected @endif>
                            {{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6 col-sm-3 col-xs-2">
                <select class="form-control" name="filter[region]" form="form-filter">
                    <option value="">Tất cả quốc gia</option>
                    @foreach (\Ophim\Core\Models\Region::fromCache()->all() as $item)
                        <option value="{{ $item->id }}" @if (
                            (isset(request('filter')['region']) && request('filter')['region'] == $item->id) ||
                                (isset($region) && $region->id == $item->id)) selected @endif>
                            {{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6 col-sm-3 col-xs-2">
                <select class="form-control" name="filter[year]" form="form-filter">
                    <option value="">Tất cả năm</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}" @if (isset(request('filter')['year']) && request('filter')['year'] == $year) selected @endif>
                            {{ $year }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6 col-sm-3 col-xs-2 text-center">
                <button type="submit" form="form-filter" class="btn btn-primary">Lọc</button>
            </div>
        </div>
    </form>

</div>
