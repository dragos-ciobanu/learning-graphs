<!-- Modal -->
<div class="modal fade" id="graphForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('Add new graph')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="addGraphForm">
                    <input type="hidden" name="savethisgraph" value="1">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label for="vertexNo">{{__('Vertex')}}</label>
                            <input type="text" name="vertexNo" id="vertexNo" class="form-control" placeholder="{{__('Vertex')}}" value="{{ $graph->getVerticesCount() }}">
                        </div>
                        <div class="col">
                            <label for="isCircular">{{__('Is circular')}}</label>
                            <input class="form-control" type="checkbox" value="true" id="isCircular" name="isCircular" @isset($isCircleGraph)checked="{{ $isCircleGraph }}"@endisset>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edges">{{__('Edges list')}}</label>
                        <textarea class="form-control" name="edges" id="edges" rows="10">@foreach( $graph->getEdges() as $edge){{ $edge[0] . ' ' . $edge[1] . "\n" }}@endforeach</textarea>
                    </div>
                    <div class="form-group">
                        <label for="candidate">{{__('Clique candidate')}}</label>
                        <input type="text" name="candidate" id="candidate" class="form-control" placeholder="{{__('Clique candidate')}}" value="@isset($candidate){{ implode(' ', $candidate) }}@endisset">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                <button type="submit" class="btn btn-primary" form="addGraphForm">{{__('Save graph')}}</button>
            </div>
        </div>
    </div>
</div>
