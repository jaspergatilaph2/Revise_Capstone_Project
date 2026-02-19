document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.under-review-btn');
        const container = document.getElementById('underReviewTablesContainer');

        buttons.forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.dataset.userId;
                const userName = this.dataset.userName;

                // Check if table already exists for this user
                if(document.getElementById('underReviewTable-' + userId)) {
                    // Toggle visibility if exists
                    const existingTable = document.getElementById('underReviewTable-' + userId);
                    existingTable.classList.toggle('d-none');
                    return;
                }

                // Create table container
                const tableDiv = document.createElement('div');
                tableDiv.id = 'underReviewTable-' + userId;
                tableDiv.classList.add('mb-4');

                // Insert HTML for the new table
                tableDiv.innerHTML = `
                    <h5>${userName}'s Permit Applications - Under Review</h5>
                    <table class="table table-bordered table-striped text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Project Name</th>
                                <th>Location</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Submitted On</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $u)
                                @if($u->role === 'user')
                                    @foreach($u->permitApplications->sortByDesc('created_at') as $permit)
                                        <tr>
                                            <td>{{ $permit->project_name }}</td>
                                            <td>{{ $permit->location }}</td>
                                            <td>{{ $permit->address }}</td>
                                            <td>{{ ucfirst($permit->status) }}</td>
                                            <td>{{ $permit->created_at->format('F d, Y') }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                `;

                container.appendChild(tableDiv);
            });
        });
    });