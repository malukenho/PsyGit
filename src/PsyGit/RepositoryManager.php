<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

declare(strict_types=1);

namespace PsyGit;

use PsyGit\Command as Git;
use Symfony\Component\Process\Process;

/**
 * @author Jefersson Nathan <malukenho@phpse.net>
 */
class RepositoryManager
{
    /**
     * @var string
     */
    private $directory;

    private function __construct(string $directory)
    {
        $this->directory = $directory;
    }

    /**
     * @param $directory
     *
     * @throws \InvalidArgumentException
     *
     * @return self
     */
    public static function fromDirectory(string $directory) : self
    {
        if (! file_exists($directory . '/.git')) {
            throw new \InvalidArgumentException(sprintf('"%s" is not a valid repository path', $directory));
        }

        return new self($directory);
    }

    /**
     * @param string $directory
     *
     * @return self
     */
    public static function initializeOnDirectory(string $directory) : self
    {
        $repository = new self($directory);

        (new Git\InitializeRepository($repository->getExecutorHandler()))->__invoke($directory);

        return $repository;
    }

    /**
     * @param string $repositoryUrl
     * @param string $destinationPath
     * @param string $branch
     *
     * @return RepositoryManager
     */
    public static function cloneToDirectory(
        string $repositoryUrl,
        string $destinationPath,
        string $branch = Git\CloneRepository::BRANCH_MASTER
    ) : self {
        $repository = new self($destinationPath);

        (new Git\CloneRepository($repository->getExecutorHandler()))->__invoke($repositoryUrl, $destinationPath, $branch);

        return $repository;
    }

    /**
     * @param string $file
     *
     * @return self
     */
    public function trackFile(string $file) : self
    {
        (new Git\TrackFile($this->getExecutorHandler()))->__invoke($this->directory, $file);

        return $this;
    }

    /**
     * @return self
     */
    public function trackAllFiles() : self
    {
        (new Git\TrackAllFiles($this->getExecutorHandler()))->__invoke($this->directory);

        return $this;
    }

    /**
     * @param string $branch
     *
     * @return self
     */
    public function checkoutToBranch(string $branch) : self
    {
        (new Git\CheckoutToBranch($this->getExecutorHandler()))->__invoke($this->directory, $branch);

        return $this;
    }

    /**
     * @param integer $pullRequest
     * @param string $branch
     * @param string $remote
     *
     * @return self
     */
    public function fetchPullRequestToBranch(
        int $pullRequest,
        string $branch,
        $remote = Git\FetchPullRequestNumber::DEFAULT_REMOTE
    ) : self {
        (new Git\FetchPullRequestNumber($this->getExecutorHandler()))->__invoke($this->directory, $pullRequest, $branch, $remote);

        return $this;
    }

    /**
     * @param string $newBranchName
     *
     * @return self
     */
    public function createNewBranch(string $newBranchName) : self
    {
        (new Git\NewBranchFromBranch($this->getExecutorHandler()))->__invoke($this->directory, $newBranchName);

        return $this;
    }

    /**
     * @param string $alias
     * @param string $remoteUrl
     *
     * @return self
     */
    public function remoteAdd(string $alias, string $remoteUrl) : self
    {
        (new Git\RemoteAdd($this->getExecutorHandler()))->__invoke($this->directory, $alias, $remoteUrl);

        return $this;
    }

    /**
     * @param string $alias
     *
     * @return self
     */
    public function remoteRemove(string $alias) : self
    {
        (new Git\RemoteRemove($this->getExecutorHandler()))->__invoke($this->directory, $alias);

        return $this;
    }

    /**
     * @param string $commit
     *
     * @return self
     */
    public function cherryPick(string $commit) : self
    {
        (new Git\CherryPick($this->getExecutorHandler()))->__invoke($this->directory, $commit);

        return $this;
    }

    /**
     * @param string $message
     *
     * @return self
     */
    public function commit(string $message) : self
    {
        (new Git\Commit($this->getExecutorHandler()))->__invoke($this->directory, $message);

        return $this;
    }

    /**
     * @param string $remoteAlias
     * @param string $branch
     * @param string $option
     *
     * @return self
     */
    public function push(string $remoteAlias, string $branch, $option = Git\Push::PUSH_NORMAL) : self
    {
        (new Git\Push($this->getExecutorHandler()))->__invoke($this->directory, $remoteAlias, $branch, $option);

        return $this;
    }

    private function getExecutorHandler() : callable
    {
        return function (string $command) {
            $process = new Process($command);

            return $process->run();
        };
    }
}
