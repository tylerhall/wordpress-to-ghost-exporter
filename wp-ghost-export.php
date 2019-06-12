<?PHP
    $db_host = '';
    $db_user = '';
    $db_pass = '';
    $db_name = '';

    $author_name = 'First Last';
    $author_email = 'user@domain.com';

    // =================================================

    $db = mysqli_connect($db_host, $db_user, $db_pass) or die('connect');
    mysqli_select_db($db, $db_name) or die('select');

    $out = [];
    $out['meta'] = ['exported_on' => microtime(), 'version' => '2.14.0'];

    $data = [];
    $data['users'] = [['id' => 1, 'name' => $author_name, 'email' => $author_email]];

    $query = "SELECT * FROM wp_posts WHERE post_status = 'publish' AND post_type = 'post'";
    $results = mysqli_query($db, $query);
    $posts = [];
    while($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
        if(strlen($row['post_title']) > 0) {
            $post = [];
            $post['title'] = $row['post_title'];
            $post['slug'] = $row['post_name'];
            $post['status'] = 'published';
            $post['created_at'] = $row['post_date'];
            $post['updated_at'] = $row['post_date'];
            $post['published_at'] = $row['post_date'];
            $post['id'] = $row['ID'];
            $post['author_id'] = 1;

            $mobiledoc = [];
            $mobiledoc['version'] = '0.3.1';
            $mobiledoc['markups'] = [];
            $mobiledoc['atoms'] = [];
            $dict = ['cardName' => 'markdown', 'markdown' => $row['post_content']];
            $mobiledoc['cards'] = [['markdown', $dict]];
            $mobiledoc['sections'] = [[10, 0]];

            $json = json_encode($mobiledoc, JSON_INVALID_UTF8_IGNORE);
            if($json === false) {
                print_r($mobiledoc);
                die('bad json');
            }

            $post['mobiledoc'] = $json;

            $posts[] = $post;
        }
    }
    $data['posts'] = $posts;

    $query = "SELECT * FROM wp_terms";
    $results = mysqli_query($db, $query);
    $tags = [];
    while($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
        $tag = [];
        $tag['id'] = $row['term_id'];
        $tag['name'] = $row['name'];
        $tag['slug'] = $row['slug'];
        $tags[] = $tag;
    }
    $data['tags'] = $tags;

    $query = "SELECT * FROM wp_term_relationships";
    $results = mysqli_query($db, $query);
    $posts_tags = [];
    while($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
        $tag = [];
        $tag['tag_id'] = $row['term_taxonomy_id'];
        $tag['post_id'] = $row['object_id'];
        $posts_tags[] = $tag;
    }
    $data['posts_tags'] = $posts_tags;

    $out['data'] = $data;

    echo json_encode($out);
