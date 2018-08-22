<?php
namespace Oielr\Bot;

interface MessagerInterface {}

interface ResponceInterface {}

interface BotInterface {}

class NobodyCanProccessData extends \Exception {}

class NoRequiredDataForProcessUserMessage extends \Exception {}

class ViberResponce implements ResponceInterface
{

}

class ViberMessager implements MessagerInterface
{
    const MESSAGER_TYPE = 'viber';

    private $bot = null;

    private $responce = null;

    public function __construct(ResponceInterface $responce)
    {
        $this->responce = $responce;
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

    protected $responce = null;

    protected $command;

    protected $dispatchedMessager = null;

    public function addMessager(MessagerInterface $messager)
    {
        $messager->setBot($this);
        $this->messagers[] = $messager;
    }

    public function proccess(array $data)
    {
        foreach ($this->messagers as $messager) {
            if ($messager->proccess($data)) {

                if (!$this->getUserIdentifier() || !$this->getUserMessage() || $this->getMessagerType()) {
                    throw new NoRequiredDataForProcessUserMessage();
                }

                $nextMessage = $this->_processUserMessage(
                    $this->getUserMessage(),
                    $this->getUserIdentifier(),
                    $this->getMessagerType()
                );

                $messager->setNextMessage($nextMessage);

                $this->responce = $messager->getResponce();

                return $this;
            }
        }

        throw new NobodyCanProccessData();
    }

    public function sendResponce()
    {
        return $this->responce->send();
    }
}

interface BotAdapterInterface
{
// адаптирует информацию шага в соответвиии с форматом  ответа бота
}

class CarServiceStepBotAdapter implements BotAdapterInterface
{

}

$data = $_POST ?: $_GET;

$bot = new RequestEnrollingBot();
$bot->addMessager(new ViberMessager(new ViberResponce()));

$bot->proccess($data)->sendResponce();

























//3 часа - 22 августа, разработка интерфейсов классов (структуры) для обработки сообщений от месседжера и отправки ответа