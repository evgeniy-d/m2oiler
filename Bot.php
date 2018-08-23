<?php
namespace Oielr\Bot;

interface MessagerInterface {}

interface ResponceInterface {}

interface BotInterface {}

interface HandlerInterface {}

interface ResponceHandlerAdapterInterface {}

class CarServiceStepHandler implements HandlerInterface
{

}

class CarServiceStepViberAdapter implements ResponceHandlerAdapterInterface
{

}

class NobodyCanProccessData extends \Exception {}

class NoRequiredDataForProcessUserMessage extends \Exception {}

class CannotBeFetchedByHandlers extends \Exception {}

class ViberResponce implements ResponceInterface
{

}

class ViberMessager implements MessagerInterface
{
    const MESSAGER_TYPE = 'viber';

    private $bot = null;

    private $responce = null;

    public function __construct(ResponceInterface $responce = null)
    {
        $this->responce = $responce ?: new ViberResponce();
    }

    public function proccess(array $data)
    {
        $userMessage = '';
        $userId = '';

        if (is_array($data)) {
            $userMessage = $data['some_key'];
            $userId = $data['seme_key_user_id'];
        }

        if ($userMessage && $userId) {
            $this->_botSetData($userId, $userMessage);

            return true;
        }

        return false;
    }

    protected function _botSetData($userId, $userMessage)
    {
        $this->bot->setUserIdentifier($userId)
            ->setUserMessage($userMessage)
            ->setMessagerType(self::MESSAGER_TYPE);
    }

    public function setNextMessage(array $rawMessage)
    {
        $this->responce->setRawMessage($rawMessage);
    }

    public function setBot(BotInterface $bot)
    {
        $this->bot = $bot;
    }
}

class RequestEnrollingBot implements BotInterface
{
    protected $messagers = [];

	protected $handlers = [];

    protected $responce = null;

    public function addMessager(MessagerInterface $messager)
    {
        $messager->setBot($this);
        $this->messagers[$messager::class::MESSAGER_TYPE] = $messager;
    }

	public function addHandler(HandlerInterface $handler)
	{
		$this->handlers[] = $handler;
	}

    public function proccess(array $data)
    {
        foreach ($this->messagers as $messager) {
            if ($messager->proccess($data)) {

                if (!$this->getUserIdentifier() || !$this->getUserMessage() || $this->getMessagerType()) {
                    throw new NoRequiredDataForProcessUserMessage();
                }

                $this->responce = $messager->getResponce();

                $nextMessage = $this->_processUserMessage(
                    $this->getUserMessage(),
                    $this->getUserIdentifier(),
                    $this->getMessagerType()
                );

	            $messager->setNextMessage($nextMessage);

                return $this;
            }
        }

        throw new NobodyCanProccessData();
    }

    private function _processUserMessage(
        string $message,
		string $userId,
        string $messagerType
    ) {
		//TODO get last message from database;
		foreach ($this->handlers as $handler) {
			$lastData = [];

			$data = $handler->fetch($message, $lastData);

			if ($data) {
				$this->log($lastData['id'], $message, $userId, $messagerType);

				$data['user_id'] = $userId;
				$data['messager_type'] = $messagerType;
				$data['handler'] = $handler::class;

				return $this->_saveHandlerData($data);
			}
		}

		throw new CannotBeFetchedByHandlers;
    }

    private function _saveHandlerData($data)
    {
    	return $data;
    }

    public function sendResponce()
    {
        return $this->responce->send();
    }
}

$data = $_POST ?: $_GET;

$bot = new RequestEnrollingBot();

new CarServiceStepViberAdapter()

new ViberResponce();

$bot->addMessager(
	new ViberMessager(
		new ViberResponce([
			CarServiceStepHandler::class = new CarServiceStepViberAdapter()
		])
	)
);

$bot->addHandler(
	new CarServiceStepHandler()
);

$bot->proccess($data)->sendResponce();

























//3 часа - 22 августа, разработка интерфейсов классов (структуры) для обработки сообщений от месседжера и отправки ответа
