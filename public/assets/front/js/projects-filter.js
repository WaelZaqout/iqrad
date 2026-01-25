function filterProjects(status) {

    // Active button
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    document.getElementById('btn-' + status).classList.add('active');

    // Fetch projects
    fetch(`{{ route('projects.filter') }}?status=${status}`)
        .then(res => res.text())
        .then(html => {
            document.getElementById('projects-container').innerHTML = html;
        });
}
