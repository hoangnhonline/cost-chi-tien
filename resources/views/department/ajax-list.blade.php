<option value="">-- Phòng ban --</option>
@if($items->count() > 0)
	@foreach($items as $item)
	<option value="{{ $item->id }}">{{ $item->name }}</option>
	@endforeach
@endif