<?php
//require_once '../vsword/VsWord.php'; 
require_once 'VsWord.php'; 
VsWord::autoLoad();



class MyInitNode implements IInitNode {
	/**
	* @param string $tagName
	* @param mixed $attributes
	* @return Node
	*/
	function initNode($tagName, $attributes) {   
		if($tagName == 'p' && isset($attributes['class']) && $attributes['class'] == 'BigText') {
				$p = new PCompositeNode();
                                
                                $p->addPNodeStyle( new AlignNode(AlignNode::TYPE_CENTER) );
                                
                                
			    $r = new RCompositeNode();
			    $p->addNode($r); 
			    $r->addTextStyle(new BoldStyleNode());
			    $r->addTextStyle(new FontSizeStyleNode(36));
                            $r->addTextStyle(new UnderlineStyleNode());
                            //$r->addTextStyle(new AlignNode('TYPE_RIGHT'));
			    return $p;
		}
		return NULL;
	}
}






$doc = new VsWord(); 
$parser = new HtmlParser($doc);


//$paragraph = new PCompositeNode(); 
//$paragraph->addPNodeStyle( new AlignNode(AlignNode::TYPE_CENTER) );



$parser->addHandlerInitNode( new MyInitNode() );
//$parser->addPNodeStyle( new AlignNode(AlignNode::TYPE_CENTER) );
$parser->parse('<p class="BigText">Image 1</p><br/><img  alt="image1" src="img1.jpg">');


$parser->parse( "<p align=right>First lineep!</p>" );
$parser->parse( '<h1  align="center" width=40% style=text-align:center;>Hello world!</h1>' );
$parser->parse( '<h3 align="center">i22iHello world!</h3>' );
$parser->parse( '<p>Hello world!</p>' );
$parser->parse( "<h2>Header table</h2><center> <table width=100> <tr><td width=50>Coll 1</td><td width=50>Coll 2</td></tr> </table></center>" );
$parser->parse( $html );

//echo '<pre>'.($doc->getDocument() -> getBody() -> look()).'</pre>';

//$doc->saveAs( 'htmlparser.docx' );
$doc->saveAs( 'output.docx' );



/*
$doc2 = new VsWord();   
$paragraph = new PCompositeNode(); 
$paragraph->addPNodeStyle( new AlignNode(AlignNode::TYPE_CENTER) );
//$paragraph->addText("Some more text ... More text about... Some more text ... More text about... Some more text ... More text about...");
$paragraph->addText("Some more text ... More text about...");
//$paragraph->addTextStyle(new UnderlineStyleNode());
$doc2->getDocument()->getBody()->addNode( $paragraph );


$doc2->saveAs('output.docx');
*/



?>
<a href="output.docx">Download file</a>
<br><br>
