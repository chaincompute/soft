#[program]
pub mod compute_rewards {
    use super::*;
    
    pub fn distribute_rewards(ctx: Context<DistributeRewards>, amount: u64) -> ProgramResult {
        let user = &mut ctx.accounts.user;
        let reward = calculate_reward(amount);
        user.reward_balance += reward;
        Ok(())
    }
}

fn calculate_reward(amount: u64) -> u64 {
    // algo on compute N
    amount * 10 // coef
}
