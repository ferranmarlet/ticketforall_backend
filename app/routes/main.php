<?php

// GET route
$app->get(
    '/',
    function () {
        $template = <<<EOT
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8"/>
            <title>Restful API example</title>
            <style>
                html,body,div,span,object,iframe,
                h1,h2,h3,h4,h5,h6,p,blockquote,pre,
                abbr,address,cite,code,
                del,dfn,em,img,ins,kbd,q,samp,
                small,strong,sub,sup,var,
                b,i,
                dl,dt,dd,ol,ul,li,
                fieldset,form,label,legend,
                table,caption,tbody,tfoot,thead,tr,th,td,
                article,aside,canvas,details,figcaption,figure,
                footer,header,hgroup,menu,nav,section,summary,
                time,mark,audio,video{margin:0;padding:0;border:0;outline:0;font-size:100%;vertical-align:baseline;background:transparent;}
                body{line-height:1;}
                article,aside,details,figcaption,figure,
                footer,header,hgroup,menu,nav,section{display:block;}
                nav ul{list-style:none;}
                blockquote,q{quotes:none;}
                blockquote:before,blockquote:after,
                q:before,q:after{content:'';content:none;}
                a{margin:0;padding:0;font-size:100%;vertical-align:baseline;background:transparent;}
                ins{background-color:#ff9;color:#000;text-decoration:none;}
                mark{background-color:#ff9;color:#000;font-style:italic;font-weight:bold;}
                del{text-decoration:line-through;}
                abbr[title],dfn[title]{border-bottom:1px dotted;cursor:help;}
                table{border-collapse:collapse;border-spacing:0;}
                hr{display:block;height:1px;border:0;border-top:1px solid #cccccc;margin:1em 0;padding:0;}
                input,select{vertical-align:middle;}
                html{ background: #EDEDED; height: 100%; }
                body{background:#FFF;margin:0 auto;min-height:100%;padding:30px 30px;width:800px;color:#666;font:14px/23px Arial,Verdana,sans-serif;}
                h1,h2,h3,p,ul,ol,form,section{margin:0 0 20px 0;}
                h1{color:#333;font-size:20px;}
                h2,h3{color:#333;font-size:14px;}
                h3{margin:0;font-size:12px;font-weight:bold;}
                ul,ol{list-style-position:inside;color:#999;}
                ul{list-style-type:square;}
                code,kbd{background:#EEE;border:1px solid #DDD;border:1px solid #DDD;border-radius:4px;-moz-border-radius:4px;-webkit-border-radius:4px;padding:0 4px;color:#666;font-size:12px;}
                pre{background:#EEE;border:1px solid #DDD;border-radius:4px;-moz-border-radius:4px;-webkit-border-radius:4px;padding:5px 10px;color:#666;font-size:12px;}
                pre code{background:transparent;border:none;padding:0;}
                a{color:#70a23e;}
                header{padding: 30px 0;text-align:center;}
            </style>
        </head>
        <body>
            <header>
              <h1>
                Restful API example
              </h1>
              <h2>
                Developed using Slim php microframework, RedBeanPHP ORM and (coming soon) Twig template engine
              </h2>
            </header>
            <section>
            <p>
                This example application implements an API which manages a very simple customer database.
            </p>
            <p>
                This database contains one single table, called customer.
            </p>
            <p>
                The CRUD API methos allow to create, update, read, and delete any customer.
            </p>
            <p>
                Customer&#39;s attributes are:
                <ul>
                  <li>id (autoincremental value assigned automatically by the database engine)</li>
                  <li>email</li>
                  <li>first_name</li>
                  <li>last_name</li>
                  <li>birth_date</li>
                </ul>

            </p>
            <p>
                <h2>Methods supported by the API</h2>
                <ul>
                    <li>GET /customer/{id_or_email} returns customer data</li>
                    <li>POST /customer creates customer, at least the email must be passed as a parameter in the request</li>
                    <li>PUT /customer/{id} updates customers params with the values passed by POST method by the request</li>
                    <li>DELETE /customer/{id} deletes the customer whitch matches the id parameter</li>
                </ul>
            </section>
            <section>
              <p>Any contributions or suggestions can be done through Github at <a href="https://github.com/ferranmarlet/slim_restful_api">this repository</a></p>
              <p>I hope it will be helfull if you are getting started with Slim for the first time.</p>
            </section>
        </body>
    </html>
EOT;
        echo $template;
    }
);

//Hello world form the "Hello world tutorial" at http://docs.slimframework.com/
$app->get('/hello/:name', function ($name) {
    echo "Hello, $name";
});

/* POST customer
params:
email (mandatory)
first_name
last_name
birth_date
*/
$app->post('/customer',function () use ($app) {
  $data = $app->request()->params();
  if(isset($data['email'])){
    $customer = R::dispense('customer');
    $customer->email = $data['email'];
    isset($data['first_name']) ? $customer->first_name = $data['first_name'] : $customer->first_name = '';
    isset($data['last_name']) ? $customer->last_name = $data['last_name'] : $customer->last_name = '';
    isset($data['birth_date']) ? $customer->birth_date = date($data['birth_date']) : $customer->birth_date = '';

    $customerId = R::store($customer);

    $app->response->headers->set('Content-Type', 'application/json');
    $app->response->setBody(json_encode ($customer->export()));

  }else{
    $app->response->setStatus(400); //Http status code 400 means "Bad request"
    $app->response->headers->set('Content-Type', 'application/json');
    $app->response->setBody(json_encode(array('message'=>'Email must be set')));
  }
});

/* PUT customer
parameters:
email (mandatory)
first_name
last_name
birth_date

And the uri must contain the id of a customer(see below)
*/
$app->put('/customer/:id',function ($id) use ($app) {
  $data = $app->request()->params();


  $customer = R::load('customer',$id);

  if($customer->id != 0){

    if(isset($data['email'])) $customer->email = $data['email'];
    if(isset($data['first_name'])) $customer->first_name = $data['first_name'];
    if(isset($data['last_name'])) $customer->last_name = $data['last_name'];
    if(isset($data['birth_date'])) $customer->birth_date = date($data['birth_date']);

    $customerId = R::store($customer);

    $app->response->headers->set('Content-Type', 'application/json');
    $app->response->setBody(json_encode ($customer->export()));

  }else{
    $app->response->setStatus(400); //Http status code 400 means "Bad request"
    $app->response->headers->set('Content-Type', 'application/json');
    $app->response->setBody(json_encode(array('message'=>'The field id must pertain to a customer')));
  }
});

/* GET customer
parameters:
none, but the uri must contain either the id or the email of a customer (see below)
*/
$app->get('/customer/:id_or_email',function ($id_or_email) use ($app) {

  if(is_numeric($id_or_email)){
    $id = $id_or_email;
    $customer = R::load('customer',$id);
  }else{
    $email = $id_or_email;
    $customer = R::findOne('customer',' email = ? ', array($email));
  }

  if($customer->id != 0){
    $app->response->headers->set('Content-Type', 'application/json');
    $app->response->setBody(json_encode($customer->export()));
  }else{
    $app->response->setStatus(404);
    $app->response->headers->set('Content-Type', 'application/json');
    $app->response->setBody(json_encode(array('message'=>'Customer not found')));
  }

});

/* Delete customer
parameters:
none, but the uri must contain the id of a customer (see below)
*/
$app->delete('/customer/:id',function ($id) use ($app) {

  $customer = R::load('customer',$id);
  if($customer->id != 0){
    R::trash($customer);
  }else{
    $app->response->setStatus(404);
    $app->response->headers->set('Content-Type', 'application/json');
    $app->response->setBody(json_encode(array('message'=>'Customer not found')));
  }
});

?>
