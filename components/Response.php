namespace SekurVentas;
use Phalcon\Http\Response;

class ResponseComponent
{
    protected $response;
    protected $status;

    public function __construct(Response $response)
    {
        $this->_response = $response;
       
    }

    public function setStatus($status){
    	$this->status = $status;
	}

	
}