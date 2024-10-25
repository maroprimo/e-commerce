
@extends('layouts.appadmin')

@section('title')
    Editer Article
@endsection

@section('contenu')

        <div class="row grid-margin">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                    <h44>Editer un article</h4>
                        @if (Session::has('status'))
                        <div class="alert alert-success">
                          {{Session::get('status')}}

                        </div>
                      
                  @endif
                    @if ($errors->any())
                        <div>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                
                    <form action="{{ route('admin.articles.modif') }}" method="POST" enctype="multipart/form-data" class="cmxform" id="commentForm">
                        @csrf
                        <div class="form-group">
                        <input type="hidden" name="id" value="{{ $article->id }}">
                        <label for="title">Titre :</label>
                        <input class="form-control" type="text" name="title" id="title" value="{{ $article->title  }}">
                        </div>
                        <div class="form-group">
                        <label for="content">Contenu :</label>
                        <textarea class="form-control" name="content" id="editor">{{ $article->content  }}</textarea>
                        </div>
                        <div class="form-group">
                        <label for="image">Image :</label>
                        <input class="form-control" type="file" name="image" id="image" value="{{ $article->image  }}">
                        </div>
                        <div class="form-group">
                        <label for="category_id">Catégorie :</label>
                        <select class="form-control" name="category_name" id="category_id">
                            @foreach ($categories as $category)
                                <option value="{{ $category->name }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        </div>
                        <div class="form-group">
                        <button class="btn btn-primary" type="submit">Créer</button>
                        </div>
                    </form>
                </div>
              </div>
            </div>
          </div>
    
@endsection

@section('scripts')
  <!-- Custom js for this page-->
{{--  <script src="backend/js/form-validation.js"></script>
  <script src="backend/js/bt-maxLength.js"></script>--}}
  <!-- End custom js for this page-->
   <!-- CKEditor script -->
   <script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>
  
   <script>
       // Initialisation de CKEditor
       CKEDITOR.replace('editor', {
           toolbar: [
               { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline'] },
               { name: 'paragraph', items: ['NumberedList', 'BulletedList'] },
               { name: 'insert', items: ['Link', 'Image'] }
           ]
       });
   </script>  
@endsection

