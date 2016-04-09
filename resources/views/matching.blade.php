<table class="table table-striped table-bordered">
    <tr>
        <th>Agent Id</th>
        <th>Contact Name</th>
        <th>Contact Zipcode</th>
    </tr>
    @foreach ($matching as $match)
    <tr>
        <td>{{ $match->agentid}}</td>
        <td>{{ $match->name}}</td>
        <td>{{ $match->zipcode}}</td>
    </tr>
    @endforeach
</table>