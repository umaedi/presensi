@if ($paginator->hasPages())
<div class="col-md-7">
    <ul class="pagination">
        @if ($paginator->onFirstPage())
            <li class="previous disabled" id="swdatatable_previous">
                <a href="#" aria-controls="swdatatable" data-dt-idx="0" tabindex="0">Previous</a>
            </li>
        @else
            <li class="previous disabled" id="swdatatable_previous">
                <a  onclick="loadPaginate({{ explode('page=', $paginator->previousPageUrl())[1]}})" aria-controls="swdatatable" href="javascript:void(0);" data-dt-idx="0" tabindex="0">Previous</a>
            </li>
        @endif
        
        @if ($paginator->hasMorePages())
            <li class="next disabled">
                <a onclick="loadPaginate({{ explode('page=',$paginator->nextPageUrl())[1]}})" href="javascript:void(0)">Next</a>
            </li>
        @else
            <li class="next disabled">
                <a href="#" data-dt-idx="1" tabindex="0">Next</a>
            </li>
        @endif
       
    </ul>
</div>
@endif
