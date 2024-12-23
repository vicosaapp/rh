<table>
    <thead>
        <tr>
            <!-- ... outras colunas ... -->
            <th>{{ __('Created By') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($employees as $employee)
        <tr>
            <!-- ... outras colunas ... -->
            <td>
                @php
                    $creator = DB::table('users')
                        ->where('id', $employee->created_by)
                        ->first();
                @endphp
                {{ $creator ? $creator->name : 'N/A' }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table> 