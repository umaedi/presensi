@foreach ($table as $tb)
    <div class="demo-vertical-spacing">
      <a href="/admin/presensi/opd/show/{{ $tb->opd_id }}">
        <div class="text-light small fw-semibold mb-1">{{ $tb->opd->nama_opd }}</div>
        <div class="progress mb-3">
            <div
                class="progress-bar"
                role="progressbar"
                style="width: {{ round($tb->total_presensi / $tb->total_user * 100) }}%"
                aria-valuenow="{{ round($tb->total_presensi / $tb->total_user * 100) }}"
                aria-valuemin="0"
                aria-valuemax="100"
            >
                {{ round($tb->total_presensi / $tb->total_user * 100) }}%
            </div>
        </div>
      </a>
    </div>
@endforeach
