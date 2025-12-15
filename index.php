<?php
require_once("config/process.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>README.ai</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class="main-header">
        <nav>
            <ul>
                <h1 id="main-title">
                    <a href="index.php">
                        README.ai
                        <span class="title-by"> Powered by</span>
                        <span class="title-author">Clovis</span>
                    </a>
                </h1>
            </ul>
        </nav>
        <div class="user-icon">
            <div class="avatar">D</div>
        </div>
    </header>

    <div class="chat-container">
        <div class="main-container">
            <div class="messages-container" id="messages">
                <?php foreach ($_SESSION["historico"] as $key => $msg): ?>
                    <div class="message <?php echo isset($msg['role']) ? $msg['role'] : 'assistant'; ?>">
                        <div class="message-avatar">
                            <?php if (($msg['role'] ?? 'assistant') === 'user'): ?>
                                D
                            <?php else: ?>
                                <img src="https://api.dicebear.com/7.x/bottts/svg?seed=<?php echo $key; ?>&backgroundColor=b6e3f4"
                                    alt="AI">
                            <?php endif; ?>
                        </div>
                        <div class="message-content"><?php echo nl2br($msg["message"] ?? $msg["content"] ?? ''); ?></div>
                    </div>
                <?php endforeach; ?>

            </div>
            <div class="prompt-box">
                <div class="input-background"></div>
                <div class="prompt-container">
                    <form id="form-limpar" action="config/process.php" method="POST">
                        <input type="hidden" name="acao" value="limpar">
                    </form>
                    <form class="form" action="config/process.php" method="post">
                        <div class="input-area">
                            <input id="prompt" name="prompt" placeholder="Digite seu prompt..." autocomplete="off"
                                required>
                        </div>
                        <div class="input-footer">
                            <div class="left-controls">
                                <button type="button" class="icon-btn plus-btn">+</button>
                                <button type="submit" form="form-limpar" class="icon-btn"
                                    title="Limpar histórico">🗑️</button>
                            </div>
                            <div class="right-controls">
                                <button type="submit" class="send-btn">➤</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>