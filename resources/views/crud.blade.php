@extends('layouts.main')
@section('title', 'Crud')
    @section('content')
        <form action="crud_submit" method="get" accept-charset="utf-8">
            <div class="row" dir="rtl">
                <div class="col" align="center"> Title </div>
                <div class="col" align="center"> Category </div>
                <div class="col" align="center"> Image </div>
            </div>
            <div class="row" dir="rtl">
                <div class="col" ><input type="text" class="form-control form-input" name="title" id="title" placeholder="Title" required></div>
                <div class="col">
                    <select class="form-control form-input" name="category" id="category" required >
                        <option value=""> Select Category</option>
                        <option value="cat1"> cat1</option>
                        <option value="cat2"> cat2</option>
                        <option value="cat3"> cat3</option>
                    </select>
                </div>
                <div class="col">
                    <input class="form-control form-input" type="file" name="img" id="img" placeholder="" required>
                </div>
            </div>
            <br>
            <div class="row" align="center">
                <button type="button" command="create" class="visible command-btn btn btn-lg btn-block btn-outline-primary">Add</button>
                <button type="button" command="update" class=" update invisible command-btn btn btn-lg btn-block btn-outline-success">update</button>
                <button type="button" command="cancel" class=" update invisible command-btn btn btn-lg btn-block btn-outline-danger">Cance</button>
            </div>
        </form>
        <hr>
        <div class="item-group" id="item-group">
            <i class="fa fa-circle-o-notch fa-spin fa-5x" style="margin-top: 2em;margin-left:6em;" ></i>
           <!--  @foreach ($model as $item)
                <div class="row item" id="item-{{$item->id}}" item="{{$item->id}}" dir="rtl" style="background: yellow">
                    <div class="col col-lg-3 title middle-height " align="center">
                        {{ $item->title }}
                    </div>
                    <div class="col col-lg-3 middle-height category" align="center">
                        {{$item->categorie}}
                    </div>
                    <div class="col col-lg-3 img" align="center">
                        <img class="img-responsive img-thumbnail" src="{{asset('storage')}}/{{$item->image}}" alt="">
                    </div>
                    <div class="col col-lg-3 middle-height" align="center">
                        <i command="delete" delete = "{{$item->id}}" class="command-btn fa fa-window-close-o item-control" ></i> 
                        <i command="view" view = "{{$item->id}}" class="command-btn fa fa-eye item-control"></i>
                    </div>
                </div>
            @endforeach -->
        </div>
    @endsection